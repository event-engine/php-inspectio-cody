<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody;

final class CodyConfig
{
    public const HOOK_ON_COMMAND = 'onCommand';

    public const HOOK_ON_AGGREGATE = 'onAggregate';

    public const HOOK_ON_EVENT = 'onEvent';

    public const HOOK_ON_POLICY = 'onPolicy';

    public const HOOK_ON_DOCUMENT = 'onDocument';

    public const HOOK_ON_EXTERNAL_SYSTEM = 'onExternalSystem';

    public const HOOK_ON_HOT_SPOT = 'onHotSpot';

    public const HOOK_ON_ROLE = 'onRole';

    public const HOOK_ON_UI = 'onUi';

    public const HOOK_ON_FEATURE = 'onFeature';

    public const HOOK_ON_BOUNDED_CONTEXT = 'onBoundedContext';

    public const HOOK_ON_SYNC = 'onSync';

    public const HOOK_ON_SYNC_UPDATED = 'onSyncUpdated';

    public const HOOK_ON_SYNC_DELETED = 'onSyncDeleted';

    /**
     * @var array
     **/
    private $hooks;

    private CodyContext $context;

    /**
     * @param CodyContext $context Context which is provided to each hook
     * @param array $hooks List of implemented hooks
     */
    public function __construct(CodyContext $context, array $hooks)
    {
        $this->context = $context;
        $this->hooks = $hooks;
    }

    public function hasHook(string $hookName): bool
    {
        return isset($this->hooks[$hookName]);
    }

    public function hook(string $hookName)
    {
        return $this->hooks[$hookName];
    }

    public function context(): CodyContext
    {
        return $this->context;
    }
}
