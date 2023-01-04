<?php

namespace CornellCustomDev\LaravelStarterKit\Tests\Feature;

use CornellCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use CornellCustomDev\LaravelStarterKit\Tests\TestCase;
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
        File::deleteDirectory("$basePath/resources/views/components/$themeName");

        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');
        $this->artisan("{$packageName}:install")
            ->expectsQuestion('Project name', $projectName)
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsConfirmation('Install cwd-framework assets?', 'yes')
            ->expectsOutputToContain('File installation complete.')
            ->assertExitCode(Command::SUCCESS);

        $this->assertFileExists("$basePath/.gitignore");
        $this->assertFileExists("$basePath/README.md");
        $this->assertFileExists("$basePath/public/$themeName/css/base.css");
        $this->assertFileDoesNotExist("$basePath/public/$themeName/sass/base.scss");
        $this->assertFileExists("$basePath/public/$themeName/favicon.ico");
        $this->assertFileExists("$basePath/resources/views/components/$themeName/layout/app.blade.php");
        $this->assertFileExists("$basePath/resources/views/$themeName-index.blade.php");
        $this->assertStringContainsString(
            needle: $projectName,
            haystack: File::get("$basePath/resources/views/$themeName-index.blade.php")
        );
    }

    public function testInstallReplacesFiles()
    {
        $composerNamespace = StarterKitServiceProvider::COMPOSER_NAMESPACE;
        $firstProjectName = 'First Project';
        $secondProjectName = 'Second Project';
        $basePath = $this->getBasePath();
        $packageName = StarterKitServiceProvider::PACKAGE_NAME;

        foreach (StarterKitServiceProvider::INSTALL_FILES as $filename) {
            File::delete("$basePath/$filename");
        }
        $file_list = Arr::join(StarterKitServiceProvider::INSTALL_FILES, ', ');

        $composerConfig = json_decode(File::get("$basePath/composer.json"), true);
        $this->assertArrayHasKey('name', $composerConfig);

        $this->artisan("$packageName:install")
            ->expectsQuestion('Project name', $firstProjectName)
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsConfirmation('Install cwd-framework assets?', 'yes');
        $contents = File::get("$basePath/README.md");
        $composerConfig = json_decode(File::get("$basePath/composer.json"), true);

        $this->assertStringContainsString($firstProjectName, $contents);
        $this->assertEquals("$composerNamespace/".Str::slug($firstProjectName), $composerConfig['name']);
        $this->assertEquals($firstProjectName.': '.StarterKitServiceProvider::PROJECT_DESCRIPTION, $composerConfig['description']);

        $this->artisan("$packageName:install")
            ->expectsQuestion('Project name', $secondProjectName)
            ->expectsConfirmation("Use Starter Kit files ($file_list)?", 'yes')
            ->expectsConfirmation('Install cwd-framework assets?', 'yes');
        $readmeContents = File::get("$basePath/README.md");
        $landoContents = File::get("$basePath/.lando.yml");

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
