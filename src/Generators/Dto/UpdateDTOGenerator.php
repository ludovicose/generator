<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Dto;

use Illuminate\Support\Str;
use Ludovicose\Generator\Generator;

final class UpdateDTOGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'dto/updateDto';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
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
        return parent::getPath() . 'Update' . $this->getName() . 'DTO.php';
    }

    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'api' => Str::lower($this->getClass()),
        ]);
    }
}
