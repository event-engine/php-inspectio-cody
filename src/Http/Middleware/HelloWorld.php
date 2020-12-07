<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final class HelloWorld
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
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
    }
}
