# Contributing to CD-LaravelStarterKit

## Getting Started
There are several places for information on what needs to be worked on:
- See the #cd-laravel-starter-kit CIT Slack channel for current activity.
- See the [GitHub project discussions](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/discussions) for general notes and discussion.
- See the [GitHub issues list](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/issues) and [pull requests](https://github.com/CU-CommunityApps/CD-LaravelStarterKit/pulls) for work that needs to be done or reviewed.

## Local Development Setup
The Laravel Starter Kit is a package, so the development and use of it is not the same as a Laravel project. It may be of use to read [Laravel Package Development](https://laravelpackage.com/) and the [Laravel Package Development documentation](https://laravel.com/docs/9.x/packages).

Local development of CD-LaravelStarterKit requires an environment with php, composer, and git. The `.lando.yml` provided in this package can set up that environment in Docker (run `lando start`) and then a shell with that environment can be used by running `lando ssh`.

### Installing dependencies
To fully set up your local environment, you will need to install the composer-managed dependencies:

```shell
lando start
lando composer install
```

or, if you have `composer` version 2 installed and up-to-date locally: 

```shell
composer install
```

You should then confirm that everything is set up properly by running the tests and confirming they pass ([see Testing](#Testing) below).

## Development Standards
Meeting the goals of the Starter Kit includes developing in ways that make it easy to collaborate, maintain, and support our work.

### Design principles
Here are some principles that can apply to all development (based on [drupal.org CSS architecture goals](https://www.drupal.org/docs/develop/standards/css/css-architecture-for-drupal-9#goals)):
- Predictable: Code is consistent and understandable, doing what is expected without side effects
- Reusable: Code is abstract and decoupled enough that you can build new components quickly from existing parts without having to recode patterns and problems you’ve already solved
- Maintainable: as new work is needed, it should be easy to add or refactor existing code
- Scalable: code should be easy to manage for a single developer and distributed teams

### Code style and linting
Laravel coding conventions and style can be followed in part by using automated linting. All pull requests must pass code style linting. Code linting in this starter kit is set up to use [Laravel Pint](https://laravel.com/docs/9.x/pint), which can be run with
  ```shell
  lando pint
  ```
or
  ```shell
  php ./vendor/bin/pint
  ```

Configuration for Pint is in `pint.json`. Use `--test` option to have errors reported without having fixes applied.

### Testing
Automated test coverage is valuable for supporting collaboration on the starter kit. All pull requests must pass unit testing. Tests written for [PHPUnit](https://phpunit.readthedocs.io/en/9.5/writing-tests-for-phpunit.html) can be run with
  ```shell
  lando phpunit
  ```
or
  ```shell
  php ./vendor/bin/phpunit
  ```

Testing utilizes the [Orchestral Testbench](https://github.com/orchestral/testbench), which creates a basic Laravel install at `vendor/orchestra/testbench-core/laravel` and runs tests in that environment.

Configuration for PHPUnit is in `.phpunit.xml`.


## Development Workflow
Work should be reviewed and approved by at least one other person via a GitHub pull request before being merged to the main branch.

### Pull request creation
There is a [pull request template](.github/pull_request_template.md) to help prompt for useful content. In addition to what is in the template, please link to any relevant content (like GitHub issues or Slack conversations) or provide context that may help inform the review process.

Pull requests are constrained in GitHub with the following automations:
- Work is only merged to the main branch via a PR
- Unit test and linting checks are run on PR code and must pass 
- PRs need to be approved by at least one other person

### Pull request review
Review feedback can generally be oriented as:

Must Fix Issues
- Bugs
- Potential maintenance issues
- Coding standard issues
- Performance issues
- Not meeting the understood need that the PR is addressing

Recommendations
- Optimization issues
- Architectural changes
- Style issues

When adding a recommendation (rather than a "must fix"), make sure the changes are worth the time and support development goals ([see README](README.md)).

When acting upon recommendations, presume that the review comment should be implemented unless there is a reason not to.
