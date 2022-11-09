<?php

namespace CUCustomDev\LaravelStarterKit\Console;

use CUCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstallStarterKit extends Command
{
    const INSTALL_FILES = [
        'README.md',
        '.lando.yml',
    ];

    protected $signature = 'starterkit:install';

    protected $description = 'Install the Custom Dev Laravel Starter Kit';

    public function handle()
    {
        $this->info('Installing StarterKit...');

        $shouldInstallFiles = $this->confirm(
            question: 'Use Starter Kit README.md and .lando.yml files?',
            default: true,
        );

        if ($shouldInstallFiles) {
            $projectName = $this->ask('Project name?');
            $this->publishFiles();
            $this->populatePlaceholders($projectName);
        }

        $this->info('Installation complete.');
    }

    private function publishFiles()
    {
        $this->call(
            command: 'vendor:publish',
            arguments: [
                '--provider' => StarterKitServiceProvider::class,
                '--tag' => 'setup',
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

}
