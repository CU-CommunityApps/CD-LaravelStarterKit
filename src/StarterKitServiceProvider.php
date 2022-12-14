<?php

namespace CUCustomDev\LaravelStarterKit;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StarterKitServiceProvider extends PackageServiceProvider
{
    const PACKAGE_NAME = 'starterkit';
    const THEME_NAME = 'cwd_framework_lite';
    public const INSTALL_FILES = [
        'README.md',
        '.lando.yml',
    ];

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            foreach (self::INSTALL_FILES as $installFileName) {
                $this->publishes([
                    __DIR__."/../project/{$installFileName}" => base_path($installFileName),
                ], self::PACKAGE_NAME.'-install');
            }
            $themeDir = '/vendor/cubear/'.self::THEME_NAME;
            $publishPath = File::isDirectory(base_path().$themeDir) ? base_path() : __DIR__.'/..';
            $this->publishes([
                $publishPath.$themeDir => public_path(self::THEME_NAME),
            ], self::THEME_NAME.'-assets');
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::PACKAGE_NAME)
            ->hasViews(self::THEME_NAME)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->startWith(fn (InstallCommand $c) => $this->install($c));
            });
    }

    private function install(InstallCommand $command)
    {
        $command->info('Installing StarterKit...');

        $file_list = Arr::join(self::INSTALL_FILES, ', ');
        $shouldInstallFiles = $command->confirm(
            question: "Use Starter Kit files ($file_list)?",
            default: true,
        );
        if ($shouldInstallFiles) {
            $projectName = $command->ask('Project name', Str::title(File::basename(base_path())));
            $this->publishFiles($command);
            $this->populatePlaceholders($projectName);
        }
        $command->info('File installation complete.');

        $themeName = self::THEME_NAME;
        $shouldInstallAssets = $command->confirm(
            question: "Use {$themeName} assets?",
            default: true,
        );
        if ($shouldInstallAssets) {
            $this->publishAssets($command);
        }
        $command->info("{$themeName} assets installed.");
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

    public function populatePlaceholders(string $projectName): void
    {
        $replacements = [
            ':project_name' => $projectName,
            ':project_slug' => Str::slug($projectName),
        ];

        foreach (self::INSTALL_FILES as $file) {
            $contents = File::get(base_path($file));

            $newContents = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $contents
            );

            File::put(base_path($file), $newContents);
        }
    }

    private function publishAssets(InstallCommand $command)
    {
        $command->call(
            command: 'vendor:publish',
            arguments: [
                '--provider' => StarterKitServiceProvider::class,
                '--tag' => self::THEME_NAME.'-assets',
                '--force' => true,
            ]
        );
    }

    private function publishViews(InstallCommand $command)
    {
        $command->call(
            command: 'vendor:publish',
            arguments: [
                '--provider' => StarterKitServiceProvider::class,
                '--tag' => self::THEME_NAME.'-views',
            ]
        );
    }
}
