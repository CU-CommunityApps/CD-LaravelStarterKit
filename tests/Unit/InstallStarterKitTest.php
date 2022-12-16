<?php

namespace CornellCustomDev\LaravelStarterKit\Tests\Unit;

use CornellCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use PHPUnit\Framework\TestCase;

class InstallStarterKitTest extends TestCase
{
    public function testStarterKitIncludesReadme()
    {
        $this->assertContains('README.md', StarterKitServiceProvider::INSTALL_FILES);
    }
}
