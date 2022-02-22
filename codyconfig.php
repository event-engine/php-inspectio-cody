<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

use EventEngine\InspectioCody\CodyConfig;

$context = new class() implements \EventEngine\InspectioCody\CodyContext {
    public function isFullSyncRequired(): bool
    {
        // TODO: Implement isFullSyncRequired() method.
        return false;
    }

    public function clearGraph(): void
    {
        // TODO: Implement clearGraph() method.
    }
}; // replace it with your own context class

return new CodyConfig(
    $context,
    [
//        CodyConfig::HOOK_ON_AGGREGATE => new AggregateHook(),
//        CodyConfig::HOOK_ON_COMMAND => new CommandHook(),
//        CodyConfig::HOOK_ON_EVENT => new EventHook(),
//        CodyConfig::HOOK_ON_POLICY => new PolicyHook(),
//        CodyConfig::HOOK_ON_DOCUMENT => new DocumentHook(),
//        CodyConfig::HOOK_ON_EXTERNAL_SYSTEM => new ExternalSystemHook(),
//        CodyConfig::HOOK_ON_HOT_SPOT => new HotSpotHook(),
//        CodyConfig::HOOK_ON_ROLE => new RoleHook(),
//        CodyConfig::HOOK_ON_UI => new UiHook(),
//        CodyConfig::HOOK_ON_FEATURE => new FeatureHook(),
//        CodyConfig::HOOK_ON_BOUNDED_CONTEXT => new BoundedContextHook(),
//        CodyConfig::HOOK_ON_SYNC => new SyncHook(),
//        CodyConfig::HOOK_ON_SYNC_UPDATED => new SyncHook(),
//        CodyConfig::HOOK_ON_SYNC_DELETED => new SyncDeletedHook(),
    ]
);
