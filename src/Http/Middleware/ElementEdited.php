<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\Board\Code;
use EventEngine\InspectioCody\Board\Exception\CodyError;
use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\General\Question;
use EventEngine\InspectioCody\Http\Route;
use EventEngine\InspectioGraphCody\JsonNode;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ElementEdited
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
        if ($request->getUri()->getPath() === Route::fullRoute(Route::ELEMENT_EDITED)
            && $request->getMethod() === RequestMethodInterface::METHOD_POST
        ) {
            try {
                return Question::checkQuestion(
                    Code::handleElementEdited(
                        JsonNode::fromJson($request->getAttribute(BodyParams::ATTRIBUTE_RAW_BODY)),
                        $this->config
                    )
                );
            } catch (\Throwable $e) {
                return CodyError::withError($e->getMessage(), [(string) $e])->response();
            }
        }

        return $next($request);
    }
}
