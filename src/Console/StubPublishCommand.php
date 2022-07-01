<?php
declare(strict_types=1);

namespace Ludovicose\Generator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

final class StubPublishCommand extends Command
{
    protected $signature = 'code:stub-publish {--force : Overwrite any existing files}';

    protected $description = 'Publish all stubs that are available for customization';

    public function handle()
    {
        $stubsBasePath    = config('generator.stubCustomizePath', 'stubs/code');
        $commandsStubPath = $stubsBasePath . "/commands/";
        $requestsStubPath = $stubsBasePath . "/requests/";

        if (!is_dir($stubsBasePath)) {
            (new Filesystem)->makeDirectory($stubsBasePath, 0755, true);

            if (!is_dir($commandsStubPath)) {
                (new Filesystem)->makeDirectory($commandsStubPath, 0755, true);
            }

            if (!is_dir($requestsStubPath)) {
                (new Filesystem)->makeDirectory($requestsStubPath, 0755, true);
            }
        }

        $files = [
            realpath(__DIR__ . '/../Stubs/commands/create.stub') => $commandsStubPath . 'create.stub',
            realpath(__DIR__ . '/../Stubs/requests/create.stub') => $requestsStubPath . 'create.stub',
        ];

        foreach ($files as $from => $to) {
            if (!file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->info('Stubs published successfully.');
    }
}
