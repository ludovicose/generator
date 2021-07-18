<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Contract;

use Ludovicose\Generator\Generator;

final class QueryContractGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'contracts/queries/query';


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'queryContract';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "{$this->getName()}Query.php";
    }
}
