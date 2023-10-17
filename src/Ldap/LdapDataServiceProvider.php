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
        $this->app->singleton(
            abstract: LdapService::class,
            concrete: fn () => new LdapService(
                ldap: new Ldap(
                    ldapUser: strval(config('ldap.user') ?: ''),
                    ldapPass: strval(config('ldap.pass') ?: ''),
                    ldapServer: strval(config('ldap.server') ?: ''),
                    ldapBaseDn: strval(config('ldap.base_dn') ?: ''),
                ),
                cacheSeconds: intval(config('ldap.cache_seconds')),
            ),
        );

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
