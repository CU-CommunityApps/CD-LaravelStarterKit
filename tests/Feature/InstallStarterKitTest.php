<?php

namespace CornellCustomDev\LaravelStarterKit\Tests\Feature;

use CornellCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use CornellCustomDev\LaravelStarterKit\Tests\TestCase;
use Illuminate\Console\Command;
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
        $projectDescription = StarterKitServiceProvider::PROJECT_DESCRIPTION;

        // Delete files from previous tests
        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }
        File::deleteDirectory("$basePath/public/$themeName");
        File::deleteDirectory("$basePath/resources/views/components/$themeName");

        $this->artisan("{$packageName}:install")
            ->expectsQuestion('Project name', $projectName)
            ->expectsQuestion('Project description', $projectDescription)
            ->expectsConfirmation('Install Starter Kit assets and files?', 'yes')
            ->expectsOutputToContain('File installation complete.')
            ->assertExitCode(Command::SUCCESS);

        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            $this->assertFileExists("$basePath/$filename");
        }
        $this->assertFileExists("$basePath/public/$themeName/css/base.css");
        $this->assertFileDoesNotExist("$basePath/public/$themeName/sass/base.scss");
        $this->assertFileExists("$basePath/public/$themeName/favicon.ico");
        $this->assertFileExists("$basePath/resources/views/components/cd/layout/app.blade.php");
        $this->assertFileExists("$basePath/resources/views/components/cd/form/form-item.blade.php");
        $this->assertFileExists("$basePath/resources/views/cd-index.blade.php");
        $this->assertStringContainsString(
            needle: $projectName,
            haystack: File::get("$basePath/resources/views/cd-index.blade.php")
        );
    }

    public function testInstallReplacesFiles()
    {
        $composerNamespace = StarterKitServiceProvider::COMPOSER_NAMESPACE;
        $firstProjectName = 'First Project';
        $firstProjectDescription = 'My first new project';
        $secondProjectName = 'Second Project';
        $secondProjectDescription = 'My second new project';
        $basePath = $this->getBasePath();
        $packageName = StarterKitServiceProvider::PACKAGE_NAME;

        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }

        $composerConfig = json_decode(File::get("$basePath/composer.json"), true);
        $this->assertArrayHasKey('name', $composerConfig);

        $this->artisan("$packageName:install")
            ->expectsQuestion('Project name', $firstProjectName)
            ->expectsQuestion('Project description', $firstProjectDescription)
            ->expectsConfirmation('Install Starter Kit assets and files?', 'yes');
        $readmeContents = File::get("$basePath/README.md");
        $envContents = File::get("$basePath/.env.example");
        $composerConfig = json_decode(File::get("$basePath/composer.json"), true);

        $this->assertStringContainsString($firstProjectName, $readmeContents);
        $this->assertStringContainsString($firstProjectDescription, $readmeContents);
        $this->assertStringContainsString($firstProjectName, $envContents);
        $this->assertStringContainsString(Str::slug($firstProjectName), $envContents);
        $this->assertEquals("$composerNamespace/".Str::slug($firstProjectName), $composerConfig['name']);
        $this->assertEquals($firstProjectDescription, $composerConfig['description']);

        $this->artisan("$packageName:install")
            ->expectsQuestion('Project name', $secondProjectName)
            ->expectsQuestion('Project description', $secondProjectDescription)
            ->expectsConfirmation('Install Starter Kit assets and files?', 'yes');
        $readmeContents = File::get("$basePath/README.md");
        $landoContents = File::get("$basePath/.lando.yml");

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
