<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http;

final class Route
{
    public const BASE = '/messages/';
    public const IIO_SAID_HELLO = 'IioSaidHello';
    public const USER_REPLIED = 'UserReplied';
    public const ELEMENT_EDITED = 'ElementEdited';
    public const CONFIRM_TEST = 'ConfirmTest';
    public const SYNC = 'Sync';

    public static function fullRoute(string $route): string
    {
        return self::BASE . $route;
    }
}
