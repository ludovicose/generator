<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Repositories;

use Ludovicose\Generator\Generator;

final class RepositoryGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'repository/repository';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode() :string
    {
        return 'repositories';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'Repository.php';
    }
}
