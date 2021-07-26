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
    public const HOOK_ON_UI = 'onUi';
    public const HOOK_ON_FEATURE = 'onFeature';
    public const HOOK_ON_BOUNDED_CONTEXT = 'onBoundedContext';
    public const HOOK_ON_SYNC = 'onSync';
    public const HOOK_ON_SYNC_DELETED = 'onSyncDeleted';

    /**
     * @var array
     **/
    private $hooks;

    private $context;

    /**
     * @var callable|null
     */
    private $fullSyncRequired;

    /**
     * @param mixed $context Context which is provided to each hook
     * @param array $hooks List of implemented hooks
     * @param callable|null $fullSyncRequired Callable to indicate whether to require full sync or not (must return true or false)
     */
    public function __construct($context, array $hooks, callable $fullSyncRequired = null)
    {
        $this->context = $context;
        $this->hooks = $hooks;
        $this->fullSyncRequired = $fullSyncRequired;
    }

    public function hasHook(string $hookName): bool
    {
        return isset($this->hooks[$hookName]);
    }

    public function hook(string $hookName)
    {
        return $this->hooks[$hookName];
    }

    /**
     * @return mixed
     */
    public function context()
    {
        return $this->context;
    }

    /**
     * Whether or not context has nodes e.g. to decide to trigger full sync
     *
     * @return bool
     */
    public function fullSyncRequired(): bool
    {
        return $this->fullSyncRequired !== null ? ($this->fullSyncRequired)() : false;
    }
}
