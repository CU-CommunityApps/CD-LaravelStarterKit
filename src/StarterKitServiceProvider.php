<?php

namespace CUCustomDev\LaravelStarterKit;

use CUCustomDev\LaravelStarterKit\Console\InstallStarterKit;
use Illuminate\Support\ServiceProvider;

class StarterKitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallStarterKit::class,
            ]);

            $paths = collect(InstallStarterKit::INSTALL_FILES)
                ->mapWithKeys(fn ($file) => [
                    __DIR__."/../project/$file" => base_path($file),
                ])->toArray();
            $this->publishes($paths, 'starterkit:install');
        }
    }

    public function register()
    {
        //
    }
}
