<?php

declare(strict_types=1);

namespace Ludovicose\Generator\Generators\Router;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ludovicose\Generator\Exceptions\RouteServiceProviderNotFoundException;
use Ludovicose\Generator\Generator;

final class RouterGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected string $stub = 'router/router';

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
        return 'router';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . Str::lower($this->getModule()) . '.php';
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
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName(): string
    {
        return ucfirst($this->getPluralName());
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return array_merge(parent::getReplacements(), [
            'controllerPath' => $this->getConfigGeneratorClassPath('controllers'),
            'controller'     => $this->getControllerName(),
            'api'            => Str::lower($this->getName()),
            'moduleApi'         => Str::lower($this->getModule()),
        ]);
    }

    protected function beforeRun()
    {
        $this->registerRouterInSystem();
        $this->addRouteToFile();
    }

    /**
     * @throws RouteServiceProviderNotFoundException
     */
    private function registerRouterInSystem(): void
    {
        $routeServiceProviderPath = base_path(config('generator.files.routeServiceProviderPath'));

        if (!File::exists($routeServiceProviderPath)) {
            throw new RouteServiceProviderNotFoundException('Не найдено файл RouteServiceProvider.php');
        }

        $routerProviderContent = File::get($routeServiceProviderPath);

        $searchText = "Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));";

        if (!Str::contains($routerProviderContent, $searchText)) {
            throw new RouteServiceProviderNotFoundException('Не найдено prefix api в файле RouteServiceProvider.php');
        }

        $stub = $this->getStubByName('router/register_route');

        if (Str::contains($routerProviderContent, $stub)) {
            return;
        }

        File::put($routeServiceProviderPath, Str::replace($searchText, $searchText . $stub, $routerProviderContent));
    }

    private function addRouteToFile()
    {
        $routeFile = $this->getPath();

        if (!File::exists($routeFile)) {
            return;
        }

        $routeFileContent = File::get($routeFile);

        $stub = $this->getStubByName('router/router_resource');

        if (Str::contains($routeFileContent, $stub)) {
            return;
        }

        $content = $routeFileContent . $stub;

        File::put($routeFile, $content);
    }
}
