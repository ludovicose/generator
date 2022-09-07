<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Handlers;

use Ludovicose\Generator\Generator;

final class CreateHandlerGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'handler/create';

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'handler';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "Create{$this->getName()}Handler.php";
    }

    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'template' => $this->getFieldsTemplate(),
        ]);
    }

    protected function getFieldsTemplate(): string
    {
        $result = '';

        foreach ($this->fields as $field) {
            $result .= "\t\t\$model->{$field[1]} = \$command->dto->{$field[1]};\n";
        }

        return $result;
    }
}
