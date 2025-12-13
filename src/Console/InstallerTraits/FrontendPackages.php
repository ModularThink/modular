<?php

namespace Modular\Modular\Console\InstallerTraits;

use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Process\Process;

trait FrontendPackages
{
    /**
     * Install the Inertia Vue Breeze stack.
     */
    protected function installFrontendPackages(): void
    {

        static::updateNodePackages(fn ($packages) => [

            '@inertiajs/vue3' => '^2.0.0',

            '@tailwindcss/forms' => '^0.5.6',
            '@tailwindcss/postcss' => '^4.0.0',
            '@tailwindcss/vite' => '^4.0.0',
            '@vitejs/plugin-vue' => '^6.0.1',

            'eslint' => '^9.5.0',
            'eslint-config-prettier' => '^10.0.2',
            'eslint-plugin-vue' => '^10.6.2',
            'vue-eslint-parser' => '^10.2.0',

            'postcss' => '^8.4.35',
            'postcss-import' => '^16.0.1',
            'prettier' => '^3.4.2',
            'prettier-plugin-blade' => '^2.1.18',
            'prettier-plugin-tailwindcss' => '^0.7.2',

            '@tiptap/vue-3' => '^2.2.4',
            '@tiptap/starter-kit' => '^2.2.4',
            '@tiptap/extension-link' => '^2.2.4',
            '@tiptap/extension-underline' => '^2.2.4',
            '@tiptap/extension-image' => '^2.2.4',
            '@tiptap/extension-youtube' => '^2.2.4',
            '@tiptap/extension-table' => '^2.2.4',
            '@tiptap/extension-table-header' => '^2.2.4',
            '@tiptap/extension-table-row' => '^2.2.4',
            '@tiptap/extension-table-cell' => '^2.2.4',

            'remixicon' => '^4.2.0',
            'tailwindcss' => '^4.0.0',
            'unplugin-vue-components' => '^30.0.0',
            'vue' => '^3.4.21',

        ] + $packages);

        $this->removesDefaultBootstrapFile();
        $this->removeDefaultTailwindConfig();
        $this->removeDefaultPostcssConfig();

        // Config files...
        copy(__DIR__.'/../../../stubs/stack-configs/postcss.config.mjs', base_path('postcss.config.mjs'));
        copy(__DIR__.'/../../../stubs/stack-configs/tailwind.config.mjs', base_path('tailwind.config.mjs'));
        copy(__DIR__.'/../../../stubs/stack-configs/jsconfig.json', base_path('jsconfig.json'));
        copy(__DIR__.'/../../../stubs/stack-configs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../../stubs/stack-configs/eslint.config.js', base_path('eslint.config.js'));
        copy(__DIR__.'/../../../stubs/stack-configs/.prettierrc.json', base_path('.prettierrc.json'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/stack-configs/.vscode', base_path('.vscode'));

        $this->components->info('Installing npm packages...');
        $this->runCommands(['npm install']);

        $this->line('');
        $this->components->info('npm packages installed successfully!');
    }

    protected static function updateNodePackages(callable $callback, bool $dev = true): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true, 512, JSON_THROW_ON_ERROR);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected function runCommands(array $commands): void
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

    protected function removesDefaultBootstrapFile(): void
    {
        $bootstrapFilePath = resource_path('js/bootstrap.js');

        if (! file_exists($bootstrapFilePath)) {
            return;
        }

        try {
            unlink($bootstrapFilePath);
            $this->components->info('Preparing frontend: default resources/js/bootstrap.js file removed.');
        } catch (\Exception $e) {
            $this->components->error('Preparing frontend: unable to remove default resources/js/bootstrap.js. Please check file permissions.');
        }
    }

    protected function removeDefaultTailwindConfig(): void
    {
        $tailwindConfigPath = base_path('tailwind.config.js');

        if (! file_exists($tailwindConfigPath)) {
            return;
        }

        try {
            unlink($tailwindConfigPath);
            $this->components->info('Preparing frontend: default tailwind.config.js file removed.');
        } catch (\Exception $e) {
            $this->components->error('Preparing frontend: unable to remove default tailwind.config.js. Please check file permissions.');
        }
    }

    protected function removeDefaultPostcssConfig(): void
    {
        $postcssConfigPath = base_path('postcss.config.js');

        if (! file_exists($postcssConfigPath)) {
            return;
        }

        try {
            unlink($postcssConfigPath);
            $this->components->info('Preparing frontend: default postcss.config.js file removed.');
        } catch (\Exception $e) {
            $this->components->error('Preparing frontend: unable to remove default postcss.config.js. Please check file permissions.');
        }
    }
}
