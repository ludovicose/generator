<?php

namespace Ludovicose\Generator\Generators\Test;

use Illuminate\Support\Str;
use Ludovicose\Generator\Generator;


final class TestGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'test/test';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace(): string
    {
        return str_replace('/', '\\', $this->getAppNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'tests';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getModule() . '/' . $this->getName() . 'Test.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return base_path();
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'api'          => Str::lower($this->getClass()),
            'moduleName'   => $this->getModule(),
            'template'     => $this->getFieldsTemplate(),
            'templateData' => $this->getDataTemplate(),
        ]);
    }

    protected function getFieldsTemplate(): string
    {
        $result = '';

        foreach ($this->fields as $field) {
            $result .= "\t\t\t\t\t\t'{$field[1]}',\n";
        }

        return $result;
    }

    protected function getDataTemplate(): string
    {
        $result = '';

        foreach ($this->fields as $field) {
            $result .= "\t\t\t'{$field[1]}' => \$model->{$field[1]},\n";
        }

        return $result;
    }
}
