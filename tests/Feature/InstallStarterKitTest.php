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

        // Delete files from previous tests
        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }
        File::deleteDirectory("$basePath/public/$themeName");
        File::deleteDirectory("$basePath/resources/views/vendor");

        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');
        $this->artisan("{$packageName}:install")
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', 'Test Project')
            ->expectsOutputToContain('File installation complete.')
            ->assertExitCode(Command::SUCCESS);

        $this->assertFileExists("$basePath/README.md");
        $this->assertFileExists("$basePath/public/$themeName/favicon.ico");

        $this->artisan('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => "{$themeName}-views",
        ]);
        $this->assertFileExists("$basePath/resources/views/vendor/$themeName/components/layout.blade.php");
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
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', $firstProjectName);
        $contents = File::get("$basePath/README.md");

        $this->assertStringContainsString($firstProjectName, $contents);

        $this->artisan("{$packageName}:install")
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsQuestion('Project name', $secondProjectName);
        $readmeContents = File::get("$basePath/README.md");
        $landoContents = File::get("$basePath/.lando.yml");

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
