<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Contract;

use Ludovicose\Generator\Generator;

final class RepositoryRemoveContractGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'contracts/repositories/remove';


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'repositoryContract';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "Remove{$this->getName()}Repository.php";
    }
}
