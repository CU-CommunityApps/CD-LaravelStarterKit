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

### Getting Started
Anyone on the Custom Development team should be welcome and able to contribute.
- See the #cd-laravel-starter-kit CIT Slack channel for current activity.
- See the [GitHub project discussions](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/discussions) for general notes and discussion.
- See the [GitHub issues list](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/issues) and [pull requests](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/pulls) for work that needs to be done or reviewed.

### Local Development Setup
The Laravel Starter Kit is a package, so the development and use of it is not the same as a Laravel project. It may be of use to read [Laravel Package Development](https://laravelpackage.com/) and the [Laravel Package Development documentation](https://laravel.com/docs/9.x/packages).

Local development of CD-LaravelStarterKit requires an environment with php, composer, and git. The `.lando.yml` provided in this package can set up that environment in Docker (run `lando start`) and then a shell with that environment can be used by running `lando ssh`.

### Testing
Automated testing using [PHPUnit](https://phpunit.readthedocs.io/en/9.5/writing-tests-for-phpunit.html) can be run with
  ```shell
  lando phpunit
  ```
or
  ```shell
  php ./vendor/bin/phpunit
  ```

Testing utilizes the [Orchestral Testbench](https://github.com/orchestral/testbench), which creates a basic Laravel install at `vendor/orchestra/testbench-core/laravel` and runs tests in that environment. 

Configuration for PHPUnit is in `.phpunit.xml`.

### Code style and linting
Code linting using [Laravel Pint](https://laravel.com/docs/9.x/pint) can be run with
  ```shell
  lando pint
  ```
or
  ```shell
  php ./vendor/bin/pint
  ```

Configuration for Pint is in `pint.json`. Use `--test` option to have errors reported without having fixes applied.

### Development Standards
In order to support working collaboratively, PHP and Laravel standards should be applied, ideally in ways that are quick and automatic.

TODO: Document standards in use and mechanisms for applying them with common tools.

### Development Workflow
All work should be reviewed and approved by at least one other developer via a GitHub pull request before being merged to the main branch.

TODO: Provide guidelines for reviews and clarify what must be done before a PR can be merged.
