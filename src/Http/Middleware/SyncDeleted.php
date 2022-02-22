<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Middleware;

use EventEngine\InspectioCody\Board\Exception\CodyError;
use EventEngine\InspectioCody\Board\Exception\CodyQuestion;
use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioCody\Http\Message\Response;
use EventEngine\InspectioCody\Http\Route;
use EventEngine\InspectioGraphCody\JsonNode;
use Fig\Http\Message\RequestMethodInterface;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SyncDeleted
{
    public const DEFAULT_DEPTH = 512;

    private const DEFAULT_OPTIONS = \JSON_BIGINT_AS_STRING | \JSON_THROW_ON_ERROR;

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
        if ($request->getUri()->getPath() === Route::fullRoute(Route::SYNC_DELETED)
            && $request->getMethod() === RequestMethodInterface::METHOD_POST
        ) {
            try {
                // server lost in memory sync, ignore sync and wait for full new sync
                if ($this->config->context()->isFullSyncRequired() === true) {
                    return Response::empty();
                }

                $data = $request->getParsedBody();

                $hookName = CodyConfig::HOOK_ON_SYNC_DELETED;

                if (! $this->config->hasHook($hookName)) {
                    return Response::fromCody(
                        [
                            "%cI'm skipping sync deleted because I cannot find a hook for it.",
                            'color: #fb9f4b; font-weight: bold',
                        ],
                        [
                            "%cIf you want me to handle \"sync deleted\", add a %c{$hookName}%c hook to codyconfig.php",
                            'color: #414141',
                            'background-color: rgba(251, 159, 75, 0.2)',
                            'color: #414141',
                        ],
                        CodyResponse::WARNING
                    );
                }

                foreach ($data['nodes'] ?? [] as $node) {
                    try {
                        $node = JsonNode::fromArray($node);
                        $hook = $this->config->hook($hookName);
                        $hook($node, $this->config->context());
                    } catch (CodyQuestion $e) {
                        return $e->response();
                    } catch (CodyError | JsonException | \Throwable $e) {
                        // ignore all errors on sync
                        continue;
                    }
                }

                return Response::empty();
            } catch (\Throwable $e) {
                return CodyError::withError($e->getMessage(), [(string) $e])->response();
            }
        }

        return $next($request);
    }
}
