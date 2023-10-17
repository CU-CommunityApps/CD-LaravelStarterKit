<?php

namespace CornellCustomDev\LaravelStarterKit\Ldap;

use CornellCustomDev\LaravelStarterKit\StarterKitServiceProvider;
use Illuminate\Support\ServiceProvider;

class LdapDataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            path: __DIR__.'/../../config/ldap.php',
            key: 'ldap',
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                paths: [
                    __DIR__.'/../../config/ldap.php' => config_path('ldap.php'),
                ],
                groups: [
                    StarterKitServiceProvider::PACKAGE_NAME.':config',
                    'ldap-config',
                ],
            );
        }
    }
}
