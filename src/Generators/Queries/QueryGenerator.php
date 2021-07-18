<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Queries;

use Ludovicose\Generator\Generator;

final class QueryGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'query/query';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode() :string
    {
        return 'queries';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'Query.php';
    }
}
