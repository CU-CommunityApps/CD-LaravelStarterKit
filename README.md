# CD-LaravelStarterKit

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

## Development and Testing

Local development of CD-LaravelStarterKit requires an environment with php, composer, and git. The `.lando.yml` provided in this package can set up that environment in Docker (run `lando start`) and then a shell with that environment can be used by running `lando ssh`.

### Testing
Automated testing is configured in phpunit.xml and can be run with
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
Code styling uses [Laravel Pint](https://laravel.com/docs/9.x/pint) and can be run with
  ```shell
  lando pint
  ```
or
  ```shell
  php ./vendor/bin/pint
  ```

Configuration for Pint is in `pint.json`.
