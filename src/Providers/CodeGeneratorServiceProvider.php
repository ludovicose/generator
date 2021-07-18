<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use Ludovicose\Generator\Console\Generate;

final class CodeGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php','generator');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->commands([
                Generate::class
            ]);

            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('generator.php'),
            ], 'config');
        }
    }
}
