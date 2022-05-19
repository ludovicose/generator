<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Providers;

use Ludovicose\Generator\Generator;

final class RepositoryServiceProviderGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'provider/repository';


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'providers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . "RepositoryServiceProvider.php";
    }
}
