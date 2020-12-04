<?php

/**
 * @see       https://github.com/event-engine/php-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Sikei\React\Http\Middleware\CorsMiddleware;
use EventEngine\InspectioCody\Http\Middleware;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$helloWorld = static function (ServerRequestInterface $request, callable $next) {
    if ($request->getUri()->getPath() === '/' && $request->getMethod() === 'GET') {
        return new Response(
            200,
            [
                'Content-Type' => 'text/plain',
            ],
            'Open a board in InspectIO, select a card, right click on it and choose "Trigger Cody" from context menu. Type "/connect http://localhost:3311" in the console.'
        );
    }

    return $next($request);
};

$finalHandler = static function (Psr\Http\Message\ServerRequestInterface $request) {
    return new React\Http\Message\Response(200);
};

$settings = [
    'server_url'            => null,
    'response_code'         => 204, // Pre-Flight Status Code
    'allow_credentials'     => true,
    'allow_origin'          => ['*'],
    'allow_origin_callback' => null,
    'allow_methods'         => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'allow_headers'         => [
        'Origin',
        'X-Requested-With',
        'Content-Type',
        'Accept',
        'X-Access-Token',
        'Authorization'
    ],
    'expose_headers'        => [],
    'max_age'               => 60 * 60 * 24 * 20, // preflight request is valid for 20 days
];

$server = new React\Http\Server(
    $loop,
    new CorsMiddleware($settings),
    $helloWorld,
    new Middleware\ForceJson(),
    new Middleware\BodyParams(),
    new Middleware\ElementEdited(require 'codyconfig.php'),
    new Middleware\UserReplied(),
    new Middleware\Greeting(),
    new Middleware\ConfirmTest(),
    $finalHandler
);

$socket = new React\Socket\Server('0.0.0.0:8080', $loop);

$server->listen($socket);

$socket->on('error', 'printf');

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

$loop->run();
