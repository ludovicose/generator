<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Traits\Criteria;

use Ludovicose\Generator\Generator;

final class CriteriaTraitGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'traits/criteria/criteria';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode() :string
    {
        return 'criteriaTrait';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'CriteriaEloquent.php';
    }
}
