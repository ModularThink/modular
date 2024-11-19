<?php

namespace Modular\Modular\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'modular:make-module {name}';

    protected $description = 'Create a new Module';

    protected string $moduleName;

    public function handle(): int
    {
        $this->setModuleName();

        $this->comment('Creating Module '.$this->moduleName);

        if ($this->createModuleDirectoryStructure()) {
            $this->createServiceProvider();

            $params = [
                'moduleName' => $this->moduleName,
                'resourceName' => $this->moduleName,
            ];

            $this->call('modular:make-controller', $params);
            $this->call('modular:make-validate', $params);
            $this->call('modular:make-model', $params);
            $this->call('modular:make-route', $params);

            $this->call('modular:make-migration', ['moduleName' => $this->moduleName, 'migrationName' => "create{$this->moduleName}s_table"]);
            $this->call('modular:make-factory', $params);

            $this->call('modular:make-page', $params);
            $this->call('modular:make-test', $params);
            // Add the {namme} Service Provider to the providers array in the bootstrap/providers.php file, appen to last line
            $provider = "Modules\\{$this->moduleName}\\{$this->moduleName}ServiceProvider::class,";
            $path = base_path('bootstrap/providers.php');
            $content = file_get_contents($path);
            // add the provider to the inside of the array return []
            $content = str_replace('];', $provider.PHP_EOL.'    ];', $content);
            file_put_contents($path, $content);
            $this->info('Module created successfully.');
            
            return self::SUCCESS;
        }

        return self::FAILURE;
    }

    private function setModulename(): void
    {
        $this->moduleName = Str::studly($this->argument('name'));
    }

    private function createServiceProvider(): void
    {
        $stub = file_get_contents(__DIR__.'/../../stubs/module-stub/modules/ModuleServiceProvider.stub');

        $stub = str_replace('{{ moduleName }}', $this->moduleName, $stub);
        $stub = str_replace('{{ resourceName }}', Str::camel($this->moduleName), $stub);

        $path = base_path("modules/{$this->moduleName}/{$this->moduleName}ServiceProvider.php");

        file_put_contents($path, $stub);
    }

    private function createModuleDirectoryStructure(): bool
    {
        $modulePath = base_path("modules/{$this->moduleName}");

        // Check if the module directory already exists
        if (File::exists($modulePath)) {
            // Output an error message to the console
            $this->info("Module {$this->moduleName} already exists. SKIPPING");

            return false;
        }

        // Create the necessary directories
        (new Filesystem)->makeDirectory($modulePath);
        (new Filesystem)->makeDirectory("{$modulePath}/Http/Controllers", 0755, true);
        (new Filesystem)->makeDirectory("{$modulePath}/Http/Requests");
        (new Filesystem)->makeDirectory("{$modulePath}/Models");
        (new Filesystem)->makeDirectory("{$modulePath}/routes");
        (new Filesystem)->makeDirectory("{$modulePath}/Tests");
        (new Filesystem)->makeDirectory("{$modulePath}/Database/Migrations", 0755, true);
        (new Filesystem)->makeDirectory("{$modulePath}/Database/Factories", 0755, true);
        (new Filesystem)->makeDirectory("{$modulePath}/Database/Seeders", 0755, true);

        return true;
    }
}
