<?php

/**
 * @see       https://github.com/event-engine/php-inspectio-cody for the canonical source repository
 * @copyright https://github.com/event-engine/php-inspectio-cody/blob/master/COPYRIGHT.md
 * @license   https://github.com/event-engine/php-inspectio-cody/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace EventEngine\InspectioCody\Board;

use OpenCodeModeling\CodeGenerator\Transformator;

abstract class BaseHook
{
    /**
     * @var Transformator\StringToFile
     **/
    private $stringToFile;

    /**
     * @var Transformator\CodeListToFiles
     **/
    private $codeListToFiles;

    public function __construct()
    {
        $this->stringToFile = new Transformator\StringToFile();
        $this->codeListToFiles = new Transformator\CodeListToFiles($this->stringToFile);
    }

    protected function writeFiles(array $codeFileList): void
    {
        ($this->codeListToFiles)($codeFileList);
    }

    protected function writeFile($code, $filename): void
    {
        ($this->stringToFile)($code, $filename);
    }
}
