<?php

namespace CornellCustomDev\LaravelStarterKit;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StarterKitServiceProvider extends PackageServiceProvider
{
    const PACKAGE_NAME = 'starterkit';

    const THEME_NAME = 'cwd-framework';

    const COMPOSER_NAMESPACE = 'cornell-custom-dev';

    const PROJECT_DESCRIPTION = 'A project built from Cornell Custom Dev Laravel Starter Kit.';

    public const INSTALL_FILES = [
        'README.md',
        '.env.example',
        '.gitignore',
        '.lando.yml',
    ];

    public const ASSET_FILES = [
        'css',
        'fonts',
        'images',
        'js',
        'favicon.ico',
    ];

    public function boot()
    {
        parent::boot();

        $themeDir = '/vendor/cubear/cwd_framework_lite';
        $themeAssetsPath = File::isDirectory(base_path().$themeDir) ? base_path() : __DIR__.'/..';

        if ($this->app->runningInConsole()) {
            foreach (self::INSTALL_FILES as $installFileName) {
                $this->publishes([
                    __DIR__."/../project/{$installFileName}" => base_path($installFileName),
                ], self::PACKAGE_NAME.'-install');
            }

            foreach (self::ASSET_FILES as $asset_file) {
                $this->publishes([$themeAssetsPath.$themeDir.'/'.$asset_file => public_path(self::THEME_NAME.'/'.$asset_file),
                ], self::THEME_NAME.'-assets');
            }
            $exampleFile = self::THEME_NAME.'-index.blade.php';
            $this->publishes([
                __DIR__.'/../resources/views/components/'.self::THEME_NAME => resource_path('/views/components/'.self::THEME_NAME),
                __DIR__."/../resources/views/$exampleFile" => resource_path("/views/$exampleFile"),
            ], self::THEME_NAME.'-assets');
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::PACKAGE_NAME)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->startWith(fn (InstallCommand $c) => $this->install($c));
            });
    }

    private function install(InstallCommand $command)
    {
        $command->info('Installing StarterKit...');

        $projectName = $command->ask('Project name', Str::title(File::basename(base_path())));

        $file_list = Arr::join(self::INSTALL_FILES, ', ');
        $shouldInstallFiles = $command->confirm(
            question: "Use Starter Kit files ($file_list)?",
            default: true,
        );
        if ($shouldInstallFiles) {
            $this->publishFiles($command);
            $this->populatePlaceholders($projectName, self::INSTALL_FILES);
            $this->updateComposerJson($projectName);
        }

        $shouldInstallAssets = $command->confirm(
            question: 'Install cwd-framework assets?',
            default: true,
        );
        if ($shouldInstallAssets) {
            $this->publishAssets($command, $projectName);
        }

        $command->info('File installation complete.');
    }

    private function publishFiles(InstallCommand $command)
    {
        $command->call(
            command: 'vendor:publish',
            arguments: [
                '--provider' => StarterKitServiceProvider::class,
                '--tag' => self::PACKAGE_NAME.'-install',
                '--force' => true,
            ]
        );
    }

    public static function populatePlaceholders(string $projectName, $files): void
    {
        $replacements = [
            ':project_name' => $projectName,
            ':project_slug' => Str::slug($projectName),
        ];

        foreach ($files as $file) {
            $contents = File::get(base_path($file));

            $newContents = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $contents
            );

            File::put(base_path($file), $newContents);
        }
    }

    private function publishAssets(InstallCommand $command, $projectName)
    {
        $command->call(
            command: 'vendor:publish',
            arguments: [
                '--provider' => StarterKitServiceProvider::class,
                '--tag' => self::THEME_NAME.'-assets',
                '--force' => true,
            ]
        );
        $this->populatePlaceholders($projectName, [
            'resources/views/'.self::THEME_NAME.'-index.blade.php',
        ]);
    }

    private function updateComposerJson(mixed $projectName)
    {
        $composerFile = base_path('composer.json');
        $composerConfig = json_decode(File::get($composerFile), true);

        $replacements = [
            'name' => self::COMPOSER_NAMESPACE.'/'.Str::slug($projectName),
            'description' => $projectName.': '.StarterKitServiceProvider::PROJECT_DESCRIPTION,
        ];

        foreach ($replacements as $key => $replacement) {
            $composerConfig[$key] = $replacement;
        }

        File::put($composerFile, json_encode($composerConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
