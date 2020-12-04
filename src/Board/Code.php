<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Board;

use EventEngine\InspectioCody\Board\Exception\CodyError;
use EventEngine\InspectioCody\Board\Exception\CodyQuestion;
use EventEngine\InspectioCody\CodyConfig;
use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioCody\Http\Message\Response;
use EventEngine\InspectioGraphCody\Node;

final class Code
{
    public static function handleElementEdited(Node $node, CodyConfig $config): CodyResponse
    {
        $hookName = 'on' . \ucfirst($node->type());

        if ($config->hasHook($hookName)) {
            $hook = $config->hook($hookName);

            try {
                return $hook($node, $config->context());
            } catch (CodyQuestion $e) {
                return $e->response();
            } catch (CodyError $e) {
                return $e->response();
            } catch (\Throwable $e) {
                return Response::fromException($node, $e);
            }
        }

        return Response::fromCody(
            [
                "%cI'm skipping \"{$node->name()}\". It's a {$node->type()}, but I cannot find a hook for it.",
                'color: #fb9f4b; font-weight: bold',
            ],
            [
                "%cIf you want me to handle \"{$node->name()}\", add a %c{$hookName}%c hook to codyconfig.php",
                'color: #414141',
                'background-color: rgba(251, 159, 75, 0.2)',
                'color: #414141',
            ],
            CodyResponse::INFO
        );
    }

    private function __construct()
    {
    }
}
