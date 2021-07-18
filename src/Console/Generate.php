<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Console;

use Illuminate\Console\Command;
use Ludovicose\Generator\Generators\Commands\CreateCommandGenerator;
use Ludovicose\Generator\Generators\Commands\RemoveCommandGenerator;
use Ludovicose\Generator\Generators\Commands\UpdateCommandGenerator;
use Ludovicose\Generator\Generators\Policy\PolicyGenerate;
use Ludovicose\Generator\Generators\Providers\BindServiceProviderGenerator;
use Ludovicose\Generator\Generators\Providers\CommandServiceProviderGenerator;
use Ludovicose\Generator\Generators\Contract\CriteriaContractGenerator;
use Ludovicose\Generator\Generators\Contract\QueryContractGenerator;
use Ludovicose\Generator\Generators\Contract\QueryPaginationContractGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryCreateContractGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryRemoveContractGenerator;
use Ludovicose\Generator\Generators\Providers\RepositoryServiceProviderGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryUpdateContractGenerator;
use Ludovicose\Generator\Generators\Contract\ServiceContractGenerator;
use Ludovicose\Generator\Generators\Controller\ControllerGenerator;
use Ludovicose\Generator\Generators\Criteria\CriteriaGenerator;
use Ludovicose\Generator\Generators\Dto\DTOGenerator;
use Ludovicose\Generator\Generators\Handlers\CreateHandlerGenerator;
use Ludovicose\Generator\Generators\Handlers\RemoveHandlerGenerator;
use Ludovicose\Generator\Generators\Handlers\UpdateHandlerGenerator;
use Ludovicose\Generator\Generators\Model\ModelGenerator;
use Ludovicose\Generator\Generators\Queries\QueryGenerator;
use Ludovicose\Generator\Generators\Repositories\RepositoryGenerator;
use Ludovicose\Generator\Generators\Requests\RequestGenerator;
use Ludovicose\Generator\Generators\Requests\RequestShowGenerator;
use Ludovicose\Generator\Generators\Resource\ResourceGenerate;
use Ludovicose\Generator\Generators\Resource\ResourcesGenerate;
use Ludovicose\Generator\Generators\Service\ServiceGenerator;
use Ludovicose\Generator\Generators\Test\TestGenerator;
use Ludovicose\Generator\Generators\Traits\Criteria\CriteriaTraitGenerator;

final class Generate extends Command
{
    protected $signature = 'code:generate {module} {name}';

    protected $description = 'Code generate';

    public function handle()
    {
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    public function fire()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        if ($this->confirm('Would you like to create a Controller, Request, Resource, Service, Dto? [y|N]')) {

            $this->generateRequest($module, $name);

            $this->generateResource($module, $name);

            $this->generateController($module, $name);

            $this->generateService($module, $name);

            $this->generateModel($module, $name);

            $this->generateRepository($module, $name);

            $this->generateCriteria($module, $name);

            $this->generateDto($module, $name);

            $this->generateTest($module, $name);

            $this->generateFactoryAndSeed($name);

            $this->generateProviders($module, $name);

            $this->generatePolicy($module, $name);
        }
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateRequest($module, $name)
    {
        (new RequestGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();


        (new RequestShowGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Request created successfully.');
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateResource($module, $name)
    {
        (new ResourcesGenerate([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new ResourceGenerate([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Resource created successfully.');
    }

    protected function generateController($module, $name)
    {
        (new ControllerGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Controller created successfully.');
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateService($module, $name)
    {
        (new ServiceGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new ServiceContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new CreateCommandGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new CreateHandlerGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new UpdateCommandGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new UpdateHandlerGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RemoveCommandGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RemoveHandlerGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();


        $this->info('Services and Commands created successfully.');
    }

    protected function generateModel($module, $name)
    {
        (new ModelGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateRepository($module, $name)
    {
        (new RepositoryCreateContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RepositoryUpdateContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RepositoryRemoveContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new QueryPaginationContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new QueryContractGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RepositoryGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new QueryGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Repository created successfully.');
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateCriteria($module, $name)
    {
        (new CriteriaGenerator([
            'module' => $module,
            'name' => $name,
        ]))->run();

        (new CriteriaContractGenerator([
            'module' => $module,
            'name' => $name,
        ]))->run();

        (new CriteriaTraitGenerator([
            'module' => $module,
            'name' => $name,
        ]))->run();


        $this->info('Criteria created successfully.');
    }

    protected function generateDto($module, $name)
    {
        (new DtoGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Dto created successfully.');
    }

    protected function generateProviders($module, $name)
    {
        (new CommandServiceProviderGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new RepositoryServiceProviderGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        (new BindServiceProviderGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Providers created successfully.');
    }

    protected function generateTest($module, $name)
    {
        (new TestGenerator([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Test created successfully.');
    }

    protected function generateFactoryAndSeed($name)
    {
        $this->call('make:factory', [
            'name' => $name . 'Factory',
            '--model' => 'Models\\' . $name
        ]);

        $this->call('make:seeder', [
            'name' => $name . 'Seeder'
        ]);
    }

    protected function generatePolicy($module, $name)
    {
        (new PolicyGenerate([
            'name' => $name,
            'module' => $module,
        ]))->run();

        $this->info('Policy created successfully.');
    }
}
