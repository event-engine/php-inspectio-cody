<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BodyParams
{
    private const SUPPORTED_METHODS = [
        RequestMethodInterface::METHOD_POST,
        RequestMethodInterface::METHOD_PUT,
    ];

    public const ATTRIBUTE_RAW_BODY = 'rawBody';

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        if (\in_array($request->getMethod(), self::SUPPORTED_METHODS, true)
            && $request->getUri()->getPath() !== '/'
            && false !== \strpos($request->getHeaderLine('Content-Type'), 'application/json')
        ) {
            $rawBody = (string) $request->getBody();

            if (empty($rawBody)) {
                $request = $request
                    ->withAttribute(self::ATTRIBUTE_RAW_BODY, $rawBody)
                    ->withParsedBody(null);
            }

            $parsedBody = \json_decode($rawBody, true);

            if (\json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException(\sprintf(
                    'Error when parsing JSON request body: %s',
                    \json_last_error_msg()
                ));
            }

            $request = $request
                ->withAttribute(self::ATTRIBUTE_RAW_BODY, $rawBody)
                ->withParsedBody($parsedBody);
        }

        return $next($request);
    }
}
