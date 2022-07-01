<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ludovicose\Generator\Exceptions\RepositoryServiceProviderNotFoundException;
use Ludovicose\Generator\Generator;

final class RepositoryServiceProviderGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'provider/repository';

    const FILE_NAME = 'RepositoryServiceProvider.php';

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return parent::getPath() . self::FILE_NAME;
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode(): string
    {
        return 'providers';
    }

    protected function beforeRun()
    {
        $this->registerSubModuleClassesInProvider();
        $this->registerSubModuleNameSpacesInProvider();
    }


    protected function registerSubModuleNameSpacesInProvider()
    {
        $repositoryServiceProviderFile = $this->getPath();

        if (!File::exists($repositoryServiceProviderFile)) {
            return;
        }

        $repositoryServiceProviderContent = File::get($repositoryServiceProviderFile);

        $searchText = 'use Illuminate\Support\ServiceProvider;';

        if (!Str::contains($repositoryServiceProviderContent, $searchText)) {
            throw new RepositoryServiceProviderNotFoundException('Не найдено use ServiceProvider в файле RepositoryServiceProvider.php');
        }

        $stub = $this->sortImports($this->getStubByName('provider/repository_namespace'));

        if (Str::contains($repositoryServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $stub . $searchText, $repositoryServiceProviderContent);

        File::put($repositoryServiceProviderFile, $content);
    }

    protected function registerSubModuleClassesInProvider()
    {
        $repositoryServiceProviderFile = $this->getPath();

        if (!File::exists($repositoryServiceProviderFile)) {
            return;
        }

        $repositoryServiceProviderContent = File::get($repositoryServiceProviderFile);

        $searchText = 'public array $bindings = [';

        if (!Str::contains($repositoryServiceProviderContent, $searchText)) {
            throw new RepositoryServiceProviderNotFoundException('Не найдено binding в файле RepositoryServiceProvider.php');
        }

        $stub = $this->getStubByName('provider/repository_class');

        if (Str::contains($repositoryServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $searchText . $stub, $repositoryServiceProviderContent);

        File::put($repositoryServiceProviderFile, $content);
    }
}
