<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Router;

use Illuminate\Support\Str;
use Ludovicose\Generator\Generator;

final class RouterGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'router/router';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'router';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'RouteRegistrar.php';
    }


    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName(): string
    {
        return ucfirst($this->getPluralName());
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'controllerPath' => $this->getConfigGeneratorClassPath('controllers'),
            'controller' => $this->getControllerName(),
            'api' => Str::lower($this->getClass()),
        ]);
    }
}
