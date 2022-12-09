<?php

namespace CUCustomDev\LaravelStarterKit\Tests\Unit;

use CUCustomDev\LaravelStarterKit\Console\InstallStarterKit;
use PHPUnit\Framework\TestCase;

class InstallStarterKitTest extends TestCase
{
    public function testStarterKitIncludesReadme()
    {
        $this->assertContains('README.md', InstallStarterKit::INSTALL_FILES);
    }
}
