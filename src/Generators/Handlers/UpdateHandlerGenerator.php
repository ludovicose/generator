<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Handlers;

use Ludovicose\Generator\Generator;

final class UpdateHandlerGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'handler/update';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'handler';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "Update{$this->getName()}Handler.php";
    }
}
