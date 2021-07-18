<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Resource;

use Ludovicose\Generator\Generator;

final class ResourcesGenerate extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'resource/resources';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'resource';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'sResource.php';
    }
}
