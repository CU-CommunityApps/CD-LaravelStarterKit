<?php

namespace CUCustomDev\LaravelStarterKit\Tests\Feature;

use CUCustomDev\LaravelStarterKit\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstallStarterKitTest extends TestCase
{
    public function testCanRunInstall()
    {
        $this->artisan('starterkit:install')
            ->expectsConfirmation('Use Starter Kit README.md and .lando.yml files?', 'yes')
            ->expectsQuestion('Project name', 'Test Project')
            ->expectsOutputToContain('Installation complete.')
            ->assertExitCode(0);
    }

    public function testInstallReplacesFiles()
    {
        $firstProjectName = 'First Project';
        $secondProjectName = 'Second Project';
        $basePath = $this->getBasePath();

        $this->artisan('starterkit:install')
            ->expectsConfirmation('Use Starter Kit README.md and .lando.yml files?', 'yes')
            ->expectsQuestion('Project name', $firstProjectName);
        $contents = File::get($basePath.DIRECTORY_SEPARATOR.'README.md');

        $this->assertStringContainsString($firstProjectName, $contents);

        $this->artisan('starterkit:install')
            ->expectsConfirmation('Use Starter Kit README.md and .lando.yml files?', 'yes')
            ->expectsQuestion('Project name', $secondProjectName);
        $readmeContents = File::get($basePath.DIRECTORY_SEPARATOR.'README.md');
        $landoContents = File::get($basePath.DIRECTORY_SEPARATOR.'.lando.yml');

        $this->assertStringContainsString($secondProjectName, $readmeContents);
        $this->assertStringContainsString(Str::slug($secondProjectName), $landoContents);
    }
}
