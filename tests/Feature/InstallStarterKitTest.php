<?php

namespace CUCustomDev\LaravelStarterKit\Tests\Feature;

use CUCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use CUCustomDev\LaravelStarterKit\Tests\TestCase;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstallStarterKitTest extends TestCase
{
    public function testCanRunInstall()
    {
        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete($this->getBasePath().DIRECTORY_SEPARATOR.$filename);
        }
        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');

        $this->artisan('starterkit:install')
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', 'Test Project')
            ->expectsOutputToContain('Installation complete.')
            ->assertExitCode(Command::SUCCESS);
    }

    public function testInstallReplacesFiles()
    {
        $firstProjectName = 'First Project';
        $secondProjectName = 'Second Project';
        $basePath = $this->getBasePath();

        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete($basePath.DIRECTORY_SEPARATOR.$filename);
        }
        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');

        $this->artisan('starterkit:install')
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', $firstProjectName);
        $contents = File::get($basePath.DIRECTORY_SEPARATOR.'README.md');

        $this->assertStringContainsString($firstProjectName, $contents);

        $this->artisan('starterkit:install')
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', $secondProjectName);
        $readmeContents = File::get($basePath.DIRECTORY_SEPARATOR.'README.md');
        $landoContents = File::get($basePath.DIRECTORY_SEPARATOR.'.lando.yml');

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
