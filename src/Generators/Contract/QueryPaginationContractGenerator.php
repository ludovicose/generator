<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Contract;

use Ludovicose\Generator\Generator;

final class QueryPaginationContractGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'contracts/queries/pagination';


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
        return parent::getPath() . "Pagination{$this->getName()}Query.php";
    }
}
