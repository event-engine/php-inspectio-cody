<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngineTest\InspectioCody\Mock;

use EventEngine\InspectioCody\CodyContext;

final class Context implements CodyContext
{
    private bool $needFullSync;

    public function __construct(bool $needFullSync)
    {
        $this->needFullSync = $needFullSync;
    }

    public function isFullSyncRequired(): bool
    {
        return $this->needFullSync;
    }

    public function clearGraph(): void
    {
    }
}
