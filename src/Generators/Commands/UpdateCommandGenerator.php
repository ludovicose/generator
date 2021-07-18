<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Commands;

use Ludovicose\Generator\Generator;

final class UpdateCommandGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'command/update';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'command';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "Update{$this->getName()}Command.php";
    }
}
