<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Contract;

use Ludovicose\Generator\Generator;

final class RepositoryUpdateContractGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'contracts/repositories/update';


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
        return parent::getPath() . "Update{$this->getName()}Repository.php";
    }
}
