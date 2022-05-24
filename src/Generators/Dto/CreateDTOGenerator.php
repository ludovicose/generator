<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Dto;

use Ludovicose\Generator\Generator;

final class CreateDTOGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'dto/createDto';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode() :string
    {
        return 'dto';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . 'Create'.$this->getName() . 'DTO.php';
    }
}
