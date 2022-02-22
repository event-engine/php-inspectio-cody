<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http;

use EventEngine\InspectioCody\CodyConfig;
use React\EventLoop\LoopInterface;
use React\Http\Middleware as ReactMiddleware;
use React\Http\Server;
use Sikei\React\Http\Middleware\CorsMiddleware;

final class ServerFactory
{
    public static function createServer(LoopInterface $loop, CodyConfig $codyConfig, array $corsSettings = []): Server
    {
        if (empty($corsSettings)) {
            $corsSettings = [
                'server_url' => null,
                'response_code' => 204, // Pre-Flight Status Code
                'allow_credentials' => true,
                'allow_origin' => ['*'],
                'allow_origin_callback' => null,
                'allow_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'allow_headers' => [
                    'Origin',
                    'X-Requested-With',
                    'Content-Type',
                    'Accept',
                    'X-Access-Token',
                    'Authorization',
                ],
                'expose_headers' => [],
                'max_age' => 60 * 60 * 24 * 20, // preflight request is valid for 20 days
            ];
        }

        return new Server(
            $loop,
            new ReactMiddleware\StreamingRequestMiddleware(),
            new ReactMiddleware\LimitConcurrentRequestsMiddleware(2),
            new ReactMiddleware\RequestBodyBufferMiddleware(), // uses post_max_size as default
            new CorsMiddleware($corsSettings),
            new Middleware\HelloWorld(),
            new Middleware\ForceJson(),
            new Middleware\BodyParams(),
            new Middleware\RequestSync($codyConfig),
            new Middleware\Sync($codyConfig),
            new Middleware\SyncDeleted($codyConfig),
            new Middleware\ElementEdited($codyConfig),
            new Middleware\UserReplied(),
            new Middleware\Greeting($codyConfig),
            new Middleware\ConfirmTest(),
            new Middleware\FinalHandler()
        );
    }
}
