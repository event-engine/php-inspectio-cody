<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\Http\Message\Response;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ForceJson
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        if ($request->getMethod() === RequestMethodInterface::METHOD_POST
            && $request->getUri()->getPath() !== '/'
            && false === \strpos($request->getHeaderLine('Content-Type'), 'application/json')
        ) {
            return Response::noJsonRequest();
        }

        return $next($request);
    }
}
