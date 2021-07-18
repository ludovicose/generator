<?php
declare(strict_types=1);

namespace Ludovicose\Generator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class Generator
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The array of options.
     *
     * @var array
     */
    protected $options;

    /**
     * The shortname of stub.
     *
     * @var string
     */
    protected $stub;


    /**
     * Create new instance of this class.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->filesystem = new Filesystem();
        $this->options = $options;
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getStub(): string
    {
        $path = config('generator.stubsOverridePath', __DIR__);

        if (!file_exists($path . '/Stubs/' . $this->stub . '.stub')) {
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' . $this->stub . '.stub', $this->getReplacements()))->render();
    }


    /**
     * Get template replacements.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        $rootNamespace = config('generator.rootNamespace');
        return [
            'class' => $this->getClass(),
            'namespace' => $this->getNamespace(),
            'root_namespace' => $this->getRootNamespace(),
            'appname' => $this->getAppNamespace(),
            'module' => $rootNamespace . $this->getModule()
        ];
    }


    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass(): string
    {
        return Str::studly(class_basename($this->getName()));
    }

    /**
     * Get class namespace.
     *
     * @return string
     */
    public function getNamespace(): ?string
    {
        $segments = $this->getSegments();
        array_pop($segments);
        $rootNamespace = $this->getRootNamespace();
        if ($rootNamespace == false) {
            return null;
        }

        return 'namespace ' . rtrim($rootNamespace . '\\' . implode('\\', $segments), '\\') . ';';
    }


    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace(): string
    {
        $rootNamespace = config('generator.rootNamespace', $this->getAppNamespace());

        return $rootNamespace . $this->getModule() . "\\" . self::getConfigGeneratorClassPath($this->getPathConfigNode());
    }


    /**
     * Get application namespace
     *
     * @return string
     */
    public function getAppNamespace(): string
    {
        return \Illuminate\Container\Container::getInstance()->getNamespace();
    }


    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return config('generator.basePath', app()->path());
    }


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->getBasePath() . '/' . $this->getModule() . '/' . self::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/';
    }


    /**
     * Get name input.
     *
     * @return string
     */
    public function getName(): string
    {
        $name = $this->name;
        if (str_contains($this->name, '\\')) {
            $name = str_replace('\\', '/', $this->name);
        }
        if (str_contains($this->name, '/')) {
            $name = str_replace('/', '/', $this->name);
        }

        return Str::studly(str_replace(' ', '/', ucwords(str_replace('/', ' ', $name))));
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return ucfirst($this->module);
    }


    /**
     * Get paths of namespace.
     *
     * @return array
     */
    public function getSegments(): array
    {
        return explode('/', $this->getName());
    }


    /**
     * Get class-specific output paths.
     *
     * @param $class
     * @param bool $directoryPath
     * @return string
     */
    public function getConfigGeneratorClassPath($class, $directoryPath = false): string
    {
        switch ($class) {
            case ('models' === $class):
                $path = config('generator.paths.models', 'Entities');
                break;
            case ('repositories' === $class):
                $path = config('generator.paths.repositories', 'Repositories');
                break;
            case ('queries' === $class):
                $path = config('generator.paths.queries', 'Queries');
                break;
            case ('controllers' === $class):
                $path = config('generator.paths.controllers', 'Controllers');
                break;
            case ('providers' === $class):
                $path = config('generator.paths.providers', 'Providers');
                break;
            case ('criteria' === $class):
                $path = config('generator.paths.criteria', 'Criteria');
                break;
            case ('services' === $class):
                $path = config('generator.paths.service', 'Services');
                break;
            case ('serviceContract' === $class):
                $path = config('generator.paths.serviceContract', 'Contracts/Services');
                break;
            case ('criteriaTrait' === $class):
                $path = config('generator.paths.criteriaTrait', 'Traits');
                break;
            case ('repositoryContract' === $class):
                $path = config('generator.paths.repositoryContract', 'Contracts/Repositories');
                break;
            case ('queryContract' === $class):
                $path = config('generator.paths.queryContract', 'Contracts/Queries');
                break;
            case ('criteriaContract' === $class):
                $path = config('generator.paths.criteriaContract', 'Contracts/Criteria');
                break;
            case ('tests' === $class):
                $path = config('generator.paths.tests', 'tests');
                break;
            case ('dto' === $class):
                $path = config('generator.paths.dto', 'dto');
                break;
            case ('request' === $class):
                $path = config('generator.paths.request', 'Request');
                break;
            case ('policy' === $class):
                $path = config('generator.paths.policy', 'Policy');
                break;
            case ('resource' === $class):
                $path = config('generator.paths.resource', 'Resource');
                break;
            case ('command' === $class):
                $path = config('generator.paths.command', 'Commands');
                break;
            case ('handler' === $class):
                $path = config('generator.paths.handler', 'Handlers');
                break;
            default:
                $path = '';
        }

        if ($directoryPath) {
            $path = str_replace('\\', '/', $path);
        } else {
            $path = str_replace('/', '\\', $path);
        }


        return $path;
    }


    /**
     * @return mixed
     */
    abstract public function getPathConfigNode();


    /**
     * Run the generator.
     *
     * @return int
     * @throws \Exception
     */
    public function run(): int
    {
        if ($this->filesystem->exists($path = $this->getPath()) && !$this->force) {
            throw new \Exception("File Already Exists $path");
        }

        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        return $this->filesystem->put($path, $this->getStub());
    }


    /**
     * Determinte whether the given key exist in options array.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function hasOption(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }


    /**
     * Get value from options by given key.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return string
     */
    public function getOption(string $key, $default = null): ?string
    {
        if (!$this->hasOption($key)) {
            return $default;
        }

        return $this->options[$key] ?: $default;
    }


    /**
     * Helper method for "getOption".
     *
     * @param string $key
     * @param string|null $default
     *
     * @return string
     */
    public function option(string $key, $default = null): ?string
    {
        return $this->getOption($key, $default);
    }


    /**
     * Handle call to __get method.
     *
     * @param string $key
     *
     * @return string|mixed
     */
    public function __get(string $key): ?string
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->option($key);
    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName(): string
    {
        return Str::singular(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName(): string
    {
        return Str::plural(lcfirst(ucwords($this->getClass())));
    }
}
