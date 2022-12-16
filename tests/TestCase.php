<?php

namespace CornellCustomDev\LaravelStarterKit\Tests;

use CornellCustomDev\LaravelStarterKit\StarterKitServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app): array
    {
        return [
            StarterKitServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
