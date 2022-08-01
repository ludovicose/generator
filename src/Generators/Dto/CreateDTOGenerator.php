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
    protected string $stub = 'dto/createDto';

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


    public function getReplacements(): array
    {

        return array_merge(parent::getReplacements(), [
            'templateField'        => $this->getFieldsTemplate(),
            'templateFieldInit' => $this->getInitFieldsTemplate(),
        ]);
    }

    protected function getFieldsTemplate(): string
    {
        $rules = '';

        foreach ($this->fields as $field) {
            $rules .= "\tpublic {$field[0]} \${$field[1]};\n";
        }

        return $rules;
    }

    protected function getInitFieldsTemplate(): string
    {
        $rules = '';

        foreach ($this->fields as $field) {
            $rules .= "\t\t\$self->{$field[1]} = \$request->get('{$field[1]}');\n";
        }

        return $rules;
    }
}
