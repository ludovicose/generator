<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Console;

use Illuminate\Console\Command;
use Ludovicose\Generator\Exceptions\FileAlreadyExistsExceptions;
use Ludovicose\Generator\Exceptions\RouteServiceProviderNotFoundException;
use Ludovicose\Generator\Generators\Commands\CreateCommandGenerator;
use Ludovicose\Generator\Generators\Commands\RemoveCommandGenerator;
use Ludovicose\Generator\Generators\Commands\UpdateCommandGenerator;
use Ludovicose\Generator\Generators\Dto\CreateDTOGenerator;
use Ludovicose\Generator\Generators\Dto\ShowDTOGenerator;
use Ludovicose\Generator\Generators\Dto\UpdateDTOGenerator;
use Ludovicose\Generator\Generators\Policy\PolicyGenerate;
use Ludovicose\Generator\Generators\Providers\BindServiceProviderGenerator;
use Ludovicose\Generator\Generators\Providers\CommandServiceProviderGenerator;
use Ludovicose\Generator\Generators\Contract\QueryContractGenerator;
use Ludovicose\Generator\Generators\Contract\QueryPaginationContractGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryCreateContractGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryRemoveContractGenerator;
use Ludovicose\Generator\Generators\Providers\RegisterServiceProviderGenerator;
use Ludovicose\Generator\Generators\Providers\RepositoryServiceProviderGenerator;
use Ludovicose\Generator\Generators\Contract\RepositoryUpdateContractGenerator;
use Ludovicose\Generator\Generators\Contract\ServiceContractGenerator;
use Ludovicose\Generator\Generators\Controller\ControllerGenerator;
use Ludovicose\Generator\Generators\Handlers\CreateHandlerGenerator;
use Ludovicose\Generator\Generators\Handlers\RemoveHandlerGenerator;
use Ludovicose\Generator\Generators\Handlers\UpdateHandlerGenerator;
use Ludovicose\Generator\Generators\Model\ModelGenerator;
use Ludovicose\Generator\Generators\Providers\RouterServiceProviderGenerator;
use Ludovicose\Generator\Generators\Queries\QueryGenerator;
use Ludovicose\Generator\Generators\Repositories\RepositoryGenerator;
use Ludovicose\Generator\Generators\Requests\CreateRequestGenerator;
use Ludovicose\Generator\Generators\Requests\RequestShowGenerator;
use Ludovicose\Generator\Generators\Requests\UpdateRequestGenerator;
use Ludovicose\Generator\Generators\Resource\MessageResourceGenerate;
use Ludovicose\Generator\Generators\Router\RouterGenerator;
use Ludovicose\Generator\Generators\Resource\ResourceGenerate;
use Ludovicose\Generator\Generators\Resource\ResourcesGenerate;
use Ludovicose\Generator\Generators\Service\ServiceGenerator;
use Ludovicose\Generator\Generators\Test\TestGenerator;

final class CodeGenerateCommand extends Command
{
    protected $signature = 'code:generate {module} {name} {--F|fields}';

    protected $description = 'Code generate';

    protected array $fields = [];

    public function handle()
    {
        if ($this->option('fields')) {
            while (true) {
                $this->info('Enter done to exit');

                $var = $this->ask("Enter variable name");

                if ($var === 'done') {
                    break;
                }

                $type = $this->choice("Enter type name", [
                    'int',
                    'string',
                    'bool',
                ]);

                $this->fields[] = [$type, $var];
            }
        }

        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    public function fire()
    {
        $module = $this->argument('module');
        $name   = $this->argument('name');

        if ($this->confirm('Would you like to create a Request, Controller, Service, Resource, Repository, Commands, Providers, Policy, Dto? [y|N]')) {

            $this->generateRequest($module, $name);

            $this->generateDto($module, $name);

            $this->generateController($module, $name);

            $this->generateService($module, $name);

            $this->generateResource($module, $name);
            exit();

            $this->generateModel($module, $name);

            $this->generateRepository($module, $name);

            $this->generateProviders($module, $name);

            $this->generatePolicy($module, $name);

            $this->generateRouter($module, $name);
        }

        if ($this->confirm('Would you like to create a Test, Factory, Seed? [y|N]')) {
            $this->generateTest($module, $name);
            $this->generateFactoryAndSeed($name);
        }
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateRequest($module, $name)
    {
        try {
            (new CreateRequestGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('CreateRequest created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("CreateRequest has exists. {$exception->getMessage()}");
        }

        try {
            (new UpdateRequestGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Update Request created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Update Request has exists. {$exception->getMessage()}");
        }

        try {
            (new RequestShowGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Show Request created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("ShowRequest has exists. {$exception->getMessage()}");
        }
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateResource($module, $name)
    {
        try {
            (new ResourcesGenerate([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Resources created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Resources has exists. {$exception->getMessage()}");
        }

        try {
            (new ResourceGenerate([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Resource created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Resource has exists. {$exception->getMessage()}");
        }

        try {
            (new MessageResourceGenerate([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('MessageResource created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("MessageResource has exists. {$exception->getMessage()}");
        }
    }

    protected function generateController($module, $name)
    {
        try {
            (new ControllerGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Controller created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Controller has exists. {$exception->getMessage()}");
        }
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateService($module, $name)
    {
        try {
            (new ServiceGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Services created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Service has exists. {$exception->getMessage()}");
        }

        try {
            (new ServiceContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Services Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Service Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new CreateCommandGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Create Command created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Create Command has exists. {$exception->getMessage()}");
        }

        try {
            (new CreateHandlerGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Create Handler created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Create Handler has exists. {$exception->getMessage()}");
        }

        try {
            (new UpdateCommandGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Update Command created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Update Command has exists. {$exception->getMessage()}");
        }

        try {
            (new UpdateHandlerGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Update Handler created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Update Handler has exists. {$exception->getMessage()}");
        }

        try {
            (new RemoveCommandGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Remove Command created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Remove Command has exists. {$exception->getMessage()}");
        }

        try {
            (new RemoveHandlerGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Remove Handler created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Remove Handler has exists. {$exception->getMessage()}");
        }

    }

    protected function generateModel($module, $name)
    {
        try {
            (new ModelGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Remove Model created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Model has exists. {$exception->getMessage()}");
        }
    }

    /**
     * @param $module
     * @param $name
     */
    protected function generateRepository($module, $name)
    {
        try {
            (new RepositoryCreateContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Create Repository Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Repository Create Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new RepositoryUpdateContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Update Repository Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Repository Update Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new RepositoryRemoveContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Remove Repository Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Repository Remove Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new QueryPaginationContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Query Pagination Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Query Pagination Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new QueryContractGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Query Contract created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Query Contract has exists. {$exception->getMessage()}");
        }

        try {
            (new RepositoryGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Repository created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Repository has exists. {$exception->getMessage()}");
        }

        try {
            (new QueryGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Query created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Query has exists. {$exception->getMessage()}");
        }
    }


    protected function generateDto($module, $name)
    {
        try {
            (new ShowDTOGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Show Dto created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Show Dto has exists. {$exception->getMessage()}");
        }

        try {
            (new CreateDTOGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Create Dto created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Create Dto has exists. {$exception->getMessage()}");
        }

        try {
            (new UpdateDTOGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Update Dto created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Update Dto has exists. {$exception->getMessage()}");
        }
    }

    protected function generateProviders($module, $name)
    {
        try {
            (new CommandServiceProviderGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('CommandServiceProvider created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("CommandServiceProvider has exists. {$exception->getMessage()}");
        }

        try {
            (new RepositoryServiceProviderGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('RepositoryServiceProviders created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("RepositoryServiceProviders has exists. {$exception->getMessage()}");
        }

        try {
            (new BindServiceProviderGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('BindServiceProvider created successfully.');

        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("BindServiceProvider has exists. {$exception->getMessage()}");
        }

        try {
            (new RegisterServiceProviderGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('RegisterServiceProviderGenerator created successfully.');

        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("RegisterServiceProviderGenerator has exists. {$exception->getMessage()}");
        }
    }

    protected function generateTest($module, $name)
    {
        try {
            (new TestGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Test created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Test has exists. {$exception->getMessage()}");
        }
    }

    protected function generateRouter($module, $name)
    {
        try {
            (new RouterGenerator([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Router created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Router has exists. {$exception->getMessage()}");
        } catch (RouteServiceProviderNotFoundException $exception) {
            $this->warn("Прошу зарегистрировать роуты в RouteServiceProvider.php");
        }
    }

    protected function generateFactoryAndSeed($name)
    {
        $this->call('make:factory', [
            'name'    => $name . 'Factory',
            '--model' => $name
        ]);

        $this->call('make:seeder', [
            'name' => $name . 'Seeder'
        ]);
    }

    protected function generatePolicy($module, $name)
    {
        try {
            (new PolicyGenerate([
                'name'   => $name,
                'module' => $module,
                'fields' => $this->fields
            ]))->run();

            $this->info('Policy created successfully.');
        } catch (FileAlreadyExistsExceptions $exception) {
            $this->warn("Policy has exists. {$exception->getMessage()}");
        }
    }
}
