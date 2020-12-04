<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\General\Question;
use EventEngine\InspectioCody\Http\Route;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ConfirmTest
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        if ($request->getUri()->getPath() === Route::fullRoute(Route::CONFIRM_TEST)
            && $request->getMethod() === RequestMethodInterface::METHOD_POST
        ) {
            return Question::checkQuestion(Question::test());
        }

        return $next($request);
    }
}
