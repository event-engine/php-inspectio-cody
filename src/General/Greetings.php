<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\General;

use EventEngine\InspectioCody\Http\Message\CodyResponse;
use EventEngine\InspectioCody\Http\Message\Response;

final class Greetings
{
    public static function greeting(string $user): CodyResponse
    {
        return Response::fromCody(
            \sprintf('Hey %s, Cody here. How can I help you?', $user),
            [
                'If you need guidance just ask me with: %c/help',
                'background-color: rgba(251, 159, 75, 0.2)',
            ],
            CodyResponse::SYNC_REQUIRED
        );
    }

    private function __construct()
    {
    }
}
