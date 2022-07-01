<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Policy;

use Ludovicose\Generator\Generator;

class PolicyGenerate extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'policy/policy';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'policy';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getName() . 'Policy.php';
    }
}
