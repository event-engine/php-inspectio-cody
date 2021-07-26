<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody;

interface CodyContext
{
    /**
     * Whether or not context has nodes e.g. to decide to trigger full sync
     *
     * @return bool
     */
    public function isFullSyncRequired(): bool;

    /**
     * Clear the graph because it's out of sync and needs complete new sync
     *
     * @return void
     */
    public function clearGraph(): void;
}
