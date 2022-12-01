# CD-LaravelStarterKit

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
2. Add the CD-LaravelStarterKit repository to `composer.json`:
   ```
   "repositories": [
     {
       "type": "vcs",
       "url": "git@github.com:CU-CommunityApps/CD-LaravelStarterKit.git"
     }
   ],
   ```
3. Composer require the CD-LaravelStarterKit
   ```shell
   composer require cu-communityapps/cd-laravelstarterkit
   ```
4. Install the Starter Kit
   ```shell
   php artisan starterkit:install
   ```
   This will publish a `README.md` and `.lando.yml` file to the base directory, configured on the project settings.

## Contributing

Anyone on the Custom Development team should be welcome and able to contribute. See [CONTRIBUTING](CONTRIBUTING.md) for details on how be involved and provide quality contributions.
