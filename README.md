# Laravel Starter Kit

A Cornell University CIT Custom Development starter kit package for Laravel.

## Goals
- Reduce time to build Laravel apps
- Increase consistency in configuration, third-party packages, and architecture
- Increase code visibility, code quality, and team collaboration
- Continuously improve code and practices
- Lower barriers for support and reduce support time

## Usage

1. Follow [standard Laravel project creation](https://laravel.com/docs/9.x/installation#your-first-laravel-project), namely
   ```shell
   composer create-project laravel/laravel example-app
   ```
2. Composer require the LaravelStarterKit
   ```shell
   composer require cornell-custom-dev/laravel-starter-kit
   ```
3. Install the Starter Kit
   ```shell
   php artisan starterkit:install
   ```
   This will publish a `README.md` and `.lando.yml` file to the base directory, configured on the project settings. It will also publish HTML/CSS/JS assets from [cwd_framework_lite](https://github.com/CU-CommunityApps/cwd_framework_lite) and a set of [view components](https://laravel.com/docs/9.x/blade#layouts-using-components) that can be used to begin a layout (see `views/cwd-framework-index.blade.php` for example usage).

Optional:
   To publish the configuration file for the Starter Kit
   ```shell
   php artisan vendor:publish --tag="starterkit-config"
   ```

## Contributing

Anyone on the Custom Development team should be welcome and able to contribute. See [CONTRIBUTING](CONTRIBUTING.md) for details on how be involved and provide quality contributions.
