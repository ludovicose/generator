<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use Ludovicose\Generator\Console\CodeGenerateCommand;
use Ludovicose\Generator\Console\StubPublishCommand;

final class CodeGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'generator');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CodeGenerateCommand::class,
                StubPublishCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('generator.php'),
            ], 'config');
        }
    }
}
