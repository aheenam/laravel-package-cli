CHANGELOG
===

This changelog contains all notable change of this project

1.2.0
---

### Changes

- the template drops support for Laravel 5.4 and adds support for Laravel 5.6
- the components are now running with Symfony 4 components

1.1.0
---

### New features

- **Pass a path:** You can now pass a path as an argument. The generator will then use this path as the base path for generating the package.
- **Adds `--no-config` flag**: You can now add this flag to prevent generating config directory. If you do not pass that flag, a `config.php` file will be created that returns an empty array.
- **Generate a LICENSE**: Previously an empty `LICENSE` file was created. Now you can choose between `MIT`, `Apache 2.0` & `GNU GPL v3` by adding the `--license` option. If you don't pass that option the LICENSE file will still be empty.

### Bugfixes

- Fixes the bug that the `composer.json` was missing a comma between two dependencies, so that running `composer install` was impossible

1.0.4: Small fixes
---
This release fixes
- that the wrong version was shown on `laravel-package --version`
- that `illuminate/support` was missing as a dependency in the composer file
- that Aheenam was still references in the README file

1.0.3 Fixes composer bug
---
Fixes that composer returns following error

`Error while installing aheenam/laravel-package-cli, composer-plugin packages should have a class defined in their extra key to be usable.`

1.0.1
---
Fixes some little issues of first release:

1. Fixes wrong installation instruction 
2. Fixes typo in composer.json

1.0.0
---
The first release containing following featuers:

1. Generate a new package with `laravel-package generate`
2. Adds a `--force` flag to ignore existing files