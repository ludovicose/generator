<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ludovicose\Generator\Exceptions\BindServiceProviderNotFoundException;
use Ludovicose\Generator\Generator;

final class BindServiceProviderGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'provider/bind';

    const FILE_NAME = 'BindServiceProvider.php';

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
        return parent::getPath() . self::FILE_NAME;
    }

    protected function beforeRun()
    {
        $this->registerSubModuleClassesInProvider();
        $this->registerSubModuleNameSpacesInProvider();
    }


    protected function registerSubModuleNameSpacesInProvider()
    {
        $bindServiceProviderFile = $this->getPath();

        if (!File::exists($bindServiceProviderFile)) {
            return;
        }

        $bindServiceProviderContent = File::get($bindServiceProviderFile);

        $searchText = 'use Illuminate\Support\ServiceProvider;';

        if (!Str::contains($bindServiceProviderContent, $searchText)) {
            throw new BindServiceProviderNotFoundException('Не найдено use ServiceProvider в файле BindServiceProvider.php');
        }

        $stub = $this->sortImports($this->getStubByName('provider/bind_namespace'));

        if (Str::contains($bindServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $stub . $searchText, $bindServiceProviderContent);

        File::put($bindServiceProviderFile, $content);
    }

    protected function registerSubModuleClassesInProvider()
    {
        $bindServiceProviderFile = $this->getPath();

        if (!File::exists($bindServiceProviderFile)) {
            return;
        }

        $bindServiceProviderContent = File::get($bindServiceProviderFile);

        $searchText = 'public array $bindings = [';

        if (!Str::contains($bindServiceProviderContent, $searchText)) {
            throw new BindServiceProviderNotFoundException('Не найдено binding в файле BindServiceProvider.php');
        }

        $stub = $this->getStubByName('provider/bind_class');

        if (Str::contains($bindServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $searchText . $stub, $bindServiceProviderContent);

        File::put($bindServiceProviderFile, $content);
    }
}
