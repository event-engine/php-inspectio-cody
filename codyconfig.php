<?php

use EventEngine\CodeGenerator\Cartridge\EventEngine\Filter\Noop;
use EventEngine\CodeGenerator\Cartridge\EventEngine\Filter\NormalizeLabel;
use EventEngine\Cody\CodyConfig;

use Laminas\Filter;

$context = new stdClass();
$context->srcFolder = 'app';
$context->appNamespace ='MyService';

// default filters
$context->filterConstName = new Filter\FilterChain();
$context->filterConstName->attach(new NormalizeLabel());
$context->filterConstName->attach(new Filter\Word\SeparatorToSeparator(' ', ''));
$context->filterConstName->attach(new Filter\Word\CamelCaseToUnderscore());
$context->filterConstName->attach(new Filter\Word\DashToUnderscore());
$context->filterConstName->attach(new Filter\StringToUpper());

$context->filterConstValue = new Filter\FilterChain();
$context->filterConstValue->attach(new NormalizeLabel());
$context->filterConstValue->attach(new Filter\Word\SeparatorToSeparator(' ', '-'));
$context->filterConstValue->attach(new Filter\Word\UnderscoreToCamelCase());
$context->filterConstValue->attach(new Filter\Word\DashToCamelCase());

$context->filterDirectoryToNamespace = new Filter\FilterChain();
$context->filterDirectoryToNamespace->attach(new Filter\Word\SeparatorToSeparator(DIRECTORY_SEPARATOR, '|'));
$context->filterDirectoryToNamespace->attach(new Filter\Word\SeparatorToSeparator('|', '\\\\'));

$context->filterNamespaceToDirectory = new Noop();

return new CodyConfig(
    $context,
    [
        CodyConfig::HOOK_ON_COMMAND => require 'example/hooks/command.php',
        CodyConfig::HOOK_ON_AGGREGATE => require 'example/hooks/aggregate.php',
        CodyConfig::HOOK_ON_EVENT => require 'example/hooks/event.php',
    ]
);
