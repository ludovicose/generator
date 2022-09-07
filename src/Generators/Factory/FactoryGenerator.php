<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Factory;

use Illuminate\Support\Str;
use Ludovicose\Generator\Generator;

class FactoryGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'factory/factory';


    public function getRootNamespace(): string
    {
        return str_replace('/', '\\', $this->getAppNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'factories';
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
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . 'Factory.php';
    }

    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'api'          => Str::lower($this->getClass()),
            'moduleName'   => $this->getModule(),
            'templateData' => $this->getDataTemplate(),
        ]);
    }

    protected function getDataTemplate(): string
    {
        $result = '';

        foreach ($this->fields as $field) {
            if ($field[0] == 'int') {
                $result .= "\t\t\t'{$field[1]}' => \$this->faker->numberBetween(1, 10000),\n";
            } elseif ($field[0] == 'bool') {
                $result .= "\t\t\t'{$field[1]}' => \$this->faker->boolean,\n";
            } else {
                $result .= "\t\t\t'{$field[1]}' => \$this->faker->word,\n";
            }
        }

        return $result;
    }
}
