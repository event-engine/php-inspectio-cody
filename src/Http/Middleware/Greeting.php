<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\General\Greetings;
use EventEngine\InspectioCody\Http\Route;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Greeting
{
    /**
     * @var CodyConfig
     **/
    private $config;

    public function __construct(CodyConfig $config)
    {
        $this->config = $config;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        if ($request->getUri()->getPath() === Route::fullRoute(Route::IIO_SAID_HELLO)
            && $request->getMethod() === RequestMethodInterface::METHOD_POST
        ) {
            $this->config->context()->clearGraph();

            return Greetings::greeting($request->getParsedBody()['user'] ?? 'Stranger');
        }

        return $next($request);
    }
}
