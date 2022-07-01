<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Service;

use Ludovicose\Generator\Generator;

final class ServiceGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'service/service';


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'services';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . $this->getServiceName() . '.php';
    }


    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getServiceName(): string
    {
        return ucfirst($this->getSingularName()) . 'Service';
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'service' => $this->getServiceName(),
            'plural' => $this->getPluralName(),
            'singular' => $this->getSingularName(),
            'appname' => $this->getRootNamespace(),
        ]);
    }
}
