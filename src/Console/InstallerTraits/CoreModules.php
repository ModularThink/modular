<?php

namespace Modular\Modular\Console\InstallerTraits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

trait CoreModules
{
    protected function configureCoreModules(): void
    {
        $this->configureMiddlewares();

        $this->call('vendor:publish', [
            '--tag' => 'modular-translations',
        ]);

        $this->copyResources();

        $this->copyModules();
        $this->configureModulesProviders();

        $this->configureModulesAutoload();

        copy(__DIR__.'/../../../stubs/routes/web.php', base_path('routes/web.php'));

        copy(__DIR__.'/../../../stubs/config/auth.php', base_path('config/auth.php'));

        copy(__DIR__.'/../../../stubs/public/favicon.svg', public_path('favicon.svg'));

        copy(__DIR__.'/../../../config/modular.php', config_path('modular.php'));

        $this->migrateDatabase();
        $this->seedDatabase();

        $this->runCommands(['npm run build']);

        $this->line('');

        $this->components->info('Core Modules configured!');
    }

    private function configureMiddlewares(): void
    {
        $this->components->info('Configuring Middlewares...');
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        copy(__DIR__.'/../../../stubs/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        $this->installMiddleware([
            '\App\Http\Middleware\HandleInertiaRequests::class',
        ]);

        $this->installMiddlewareAliases([
            'auth.user' => '\Modules\AdminAuth\Http\Middleware\UserAuth::class',
        ]);
    }

    private function copyResources(): void
    {
        $this->components->info('Copying resources directory...');
        (new Filesystem)->ensureDirectoryExists(base_path('resources'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources', base_path('resources'));
    }

    private function configureModulesAutoload(): void
    {
        $this->components->info('Configuring modules autoload...');

        // Modules...
        (new Filesystem)->ensureDirectoryExists(base_path('modules'));

        $this->configureAutoload('"database/seeders/"', '"Modules\\\": "modules/"');

        $this->dumpAutoload();
    }

    private function copyModules(): void
    {
        $this->components->info('Copying modules directory...');
        (new Filesystem)->ensureDirectoryExists(base_path('modules'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/modules', base_path('modules'));
    }

    protected function migrateDatabase(): void
    {
        (new Process([$this->phpBinary(), 'artisan', 'migrate'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    protected function seedDatabase(): void
    {
        copy(__DIR__.'/../../../stubs/database/seeders/DatabaseSeeder.php', base_path('database/seeders/DatabaseSeeder.php'));

        (new Process([$this->phpBinary(), 'artisan', 'db:seed'], base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    protected function configureModulesProviders(): void
    {
        $providersFile = base_path('bootstrap/providers.php');

        // Read the content of the file
        $content = file_get_contents($providersFile);

        // Define the string to be added
        $providersToAdd = PHP_EOL.PHP_EOL
            ."    Modules\Support\SupportServiceProvider::class,".PHP_EOL
            ."    Modules\AdminAuth\AdminAuthServiceProvider::class,".PHP_EOL
            ."    Modules\User\UserServiceProvider::class,".PHP_EOL
            ."    Modules\Dashboard\DashboardServiceProvider::class,".PHP_EOL
            ."    Modules\Acl\AclServiceProvider::class,";

        // Find the position after which you want to add the new service providers
        $searchString = "App\Providers\AppServiceProvider::class,";

        // Use the Str helper to replace
        $modifiedContent = Str::replaceFirst($searchString, $searchString.$providersToAdd, $content);

        // Write the modified content back to the file
        file_put_contents($providersFile, $modifiedContent);
    }

    protected function configureAutoload(string $after, string $path): void
    {
        $composerContent = file_get_contents(base_path('composer.json'));

        $psr4Autoloads = Str::before(Str::after($composerContent, '"autoload":'), '},');

        if (! Str::contains($psr4Autoloads, $path)) {
            $modifiedAutoload = str_replace(
                $after,
                $after.','.PHP_EOL.'            '.$path,
                $psr4Autoloads,
            );

            file_put_contents(base_path('composer.json'), str_replace(
                $psr4Autoloads,
                $modifiedAutoload,
                $composerContent
            ));
        }
    }

    protected function dumpAutoload(): void
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'dump-autoload'];
        } else {
            $command = ['composer', 'dump-autoload'];
        }

        (new Process($command, base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    protected function installMiddleware($names, $group = 'web', $modifier = 'append'): void
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $names = collect(Arr::wrap($names))
            ->filter(fn ($name) => ! Str::contains($bootstrapApp, $name))
            ->whenNotEmpty(function ($names) use ($bootstrapApp, $group, $modifier) {
                $names = $names->map(fn ($name) => "$name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware): void {',
                    '->withMiddleware(function (Middleware $middleware): void {'
                        .PHP_EOL."        \$middleware->$group($modifier: ["
                        .PHP_EOL."            $names,"
                        .PHP_EOL.'        ]);'
                        .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }

    protected function installMiddlewareAliases($aliases): void
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $aliases = collect($aliases)
            ->filter(fn ($alias) => ! Str::contains($bootstrapApp, $alias))
            ->whenNotEmpty(function ($aliases) use ($bootstrapApp) {
                $aliases = $aliases->map(fn ($name, $alias) => "'$alias' => $name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware): void {',
                    '->withMiddleware(function (Middleware $middleware): void {'
                        .PHP_EOL.'        $middleware->alias(['
                        .PHP_EOL."            $aliases,"
                        .PHP_EOL.'        ]);'
                        .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }
}
