<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

use EventEngine\InspectioCody\CodyConfig;

$context = new stdClass(); // replace it with your own context class

return new CodyConfig(
    $context,
    [
//        CodyConfig::HOOK_ON_AGGREGATE => new AggregateHook(),
//        CodyConfig::HOOK_ON_COMMAND => new CommandHook(),
//        CodyConfig::HOOK_ON_EVENT => new EventHook(),
//        CodyConfig::HOOK_ON_POLICY => new PolicyHook(),
//        CodyConfig::HOOK_ON_DOCUMENT => new DocumentHook(),
    ]
);
