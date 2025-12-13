<?php

namespace Modular\Modular\Console\InstallerTraits;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

trait PestTests
{
    protected function setupPestTests(): void
    {
        $this->components->info('Configuring Pest tests...');
        $this->configureTests();
    }

    protected function configureTests(): void
    {
        if ($this->hasComposerPackage('phpunit/phpunit')) {
            $this->removeComposerPackages(['phpunit/phpunit'], true);
        }

        if (! $this->requireComposerPackages(['pestphp/pest:^4.0', 'pestphp/pest-plugin-laravel:^4.0'], true)) {
            return;
        }

        (new Filesystem)->copy(__DIR__.'/../../../stubs/tests/Pest.php', base_path('tests/Pest.php'));
    }

    protected function hasComposerPackage(string $package): bool
    {
        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        return array_key_exists($package, $packages['require'] ?? [])
            || array_key_exists($package, $packages['require-dev'] ?? []);
    }

    protected function removeComposerPackages(array $packages, $asDev = false): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
            $asDev ? ['--dev'] : [],
            ['-W'],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    protected function requireComposerPackages(array $packages, $asDev = false): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
            ['-W'],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }
}
