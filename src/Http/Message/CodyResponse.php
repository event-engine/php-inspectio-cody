<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Http\Message;

use Psr\Http\Message\ResponseInterface;

interface CodyResponse extends ResponseInterface
{
    public const INFO = 'Info';

    public const ERROR = 'Error';

    public const WARNING = 'Warning';

    public const QUESTION = 'Question';

    public const EMPTY = 'Empty';

    public const SYNC_REQUIRED = 'SyncRequired';

    /**
     * @return string|string[]
     */
    public function cody();

    /**
     * @return string|string[]|null
     */
    public function details();

    /**
     * @return callable|null
     */
    public function reply(): ?callable;

    /**
     * @return string|null
     */
    public function type(): ?string;
}
