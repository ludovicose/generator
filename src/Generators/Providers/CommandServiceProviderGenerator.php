<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ludovicose\Generator\Exceptions\CommandServiceProviderNotFoundException;
use Ludovicose\Generator\Generator;

final class CommandServiceProviderGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'provider/command';

    const FILE_NAME = 'CommandBusServiceProviders.php';

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
        $commandServiceProviderFile = $this->getPath();

        if (!File::exists($commandServiceProviderFile)) {
            return;
        }

        $commandServiceProviderContent = File::get($commandServiceProviderFile);

        $searchText = 'use Illuminate\Support\ServiceProvider;';

        if (!Str::contains($commandServiceProviderContent, $searchText)) {
            throw new CommandServiceProviderNotFoundException('Не найдено use ServiceProvider в файле CommandBusServiceProviders.php');
        }

        $stub = $this->getStubByName('provider/command_namespace');

        if (Str::contains($commandServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $stub . $searchText, $commandServiceProviderContent);

        File::put($commandServiceProviderFile, $content);
    }

    protected function registerSubModuleClassesInProvider()
    {
        $commandServiceProviderFile = $this->getPath();

        if (!File::exists($commandServiceProviderFile)) {
            return;
        }

        $commandServiceProviderContent = File::get($commandServiceProviderFile);

        $searchText = 'private array $maps = [';

        if (!Str::contains($commandServiceProviderContent, $searchText)) {
            throw new CommandServiceProviderNotFoundException('Не найдено binding в файле CommandBusServiceProviders.php');
        }

        $stub = $this->getStubByName('provider/command_class');

        if (Str::contains($commandServiceProviderContent, $stub)) {
            return;
        }

        $content = Str::replace($searchText, $searchText . $stub, $commandServiceProviderContent);

        File::put($commandServiceProviderFile, $content);
    }
}
