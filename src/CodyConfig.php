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

    /**
     * @var array
     **/
    private $hooks;

    private $context;

    public function __construct($context, array $hooks)
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

    /**
     * @return mixed
     */
    public function context()
    {
        return $this->context;
    }
}
