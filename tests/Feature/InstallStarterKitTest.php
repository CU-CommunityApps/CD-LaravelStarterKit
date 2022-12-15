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
        $basePath = $this->getBasePath();
        $packageName = StarterKitServiceProvider::PACKAGE_NAME;
        $themeName = StarterKitServiceProvider::THEME_NAME;
        $projectName = 'Test Project';

        // Delete files from previous tests
        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }
        File::deleteDirectory("$basePath/public/$themeName");
        File::deleteDirectory("$basePath/resources/views/vendor");

        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');
        $this->artisan("{$packageName}:install")
            ->expectsQuestion('Project name', $projectName)
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsOutputToContain('File installation complete.')
            ->assertExitCode(Command::SUCCESS);

        $this->assertFileExists("$basePath/README.md");
        $this->assertFileExists("$basePath/public/$themeName/favicon.ico");
        $this->assertFileExists("$basePath/resources/views/vendor/$themeName/components/layouts/app.blade.php");
        $this->assertStringContainsString(
            needle: $projectName,
            haystack: File::get("$basePath/resources/views/vendor/$themeName/example-content.blade.php")
        );
    }

    public function testInstallReplacesFiles()
    {
        $firstProjectName = 'First Project';
        $secondProjectName = 'Second Project';
        $basePath = $this->getBasePath();
        $packageName = StarterKitServiceProvider::PACKAGE_NAME;
        $themeName = StarterKitServiceProvider::THEME_NAME;

        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }
        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');

        $this->artisan("{$packageName}:install")
            ->expectsQuestion('Project name', $firstProjectName)
        ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes');
        $contents = File::get("$basePath/README.md");

        $this->assertStringContainsString($firstProjectName, $contents);

        $this->artisan("{$packageName}:install")
            ->expectsQuestion('Project name', $secondProjectName)
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes');
        $readmeContents = File::get("$basePath/README.md");
        $landoContents = File::get("$basePath/.lando.yml");

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
