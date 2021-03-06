<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Requests;

use Ludovicose\Generator\Generator;

final class CreateRequestGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'requests/create';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode() :string
    {
        return 'request';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . 'Create'.$this->getName() . 'Request.php';
    }
}
