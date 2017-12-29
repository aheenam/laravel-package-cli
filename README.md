Laravel Package CLI
===

This project delivers a simple set of Console Commands to generate a directory structure for laravel package development.

For example simply create the complete directory structure for a new package by calling `laravel-package generate vendor/package-name`

Installation
---
Install this command as a global composer package

```bash
$ composer global require aheenam/laravel-package-cli
```

Usage
---

You can then create a new repository by calling the following command:

```bash
$ laravel-package generate vendor/package-name
```

This command will create a directory named `package-name` and will setup a basic setup for creating a Laravel package.

The directory structure will look like following:

```bash
├── database/
│   ├── .gitkeep
├── config/
│   ├── package-name.php
├── src/
│   ├── PackageNameServiceProvider.php
├── tests/
│   ├── TestCase.php
├── .gitignore
├── CHANGELOG.md
├── composer.json
├── LICENSE
├── phpunit.xml
├── README.md

```

All the files and classes will have set the correct names and namespaces, but remember that the generator is just creating a starting point. You should go through the files and add stuff that is missing.

### Pass a custom path

You can also pass an second argument specifying the path where the packages should be generated.

```bash
$ laravel-package generate vendor/package-name packages/aheenam/
```

Above example would generate the package at `./packages/aheenam/packages-name`. This can be handy if you want to use this generator within an existing Laravel project.

### The `--force` option

By default you will get an error notice if a directory with given package name already exists. You can ignore existing directories by using the `--force` flag:

```bash
$ laravel-package generate vendor/package-name --force
```

### Generate a LICENSE

You can pass an option to not only create an empty LICENSE file, but also populate it with the appropriate LICENSE content.

```bash
$ laravel-package generate vendor/package-name --license=MIT
```

Currently there are 3 LICENSE types implemented: `MIT`, `Apache 2.0` and `GNU GPL v3`. Just pass the names and you should get your LICENSE generated.

Changelog
---
Check [CHANGELOG](CHANGELOG.md) for the changelog

Testing
---
To run tests use

```bash
$ composer test
```

If you are working on a windows machine use

```bash
vendor\bin\phpunit
```

Contributing
---
*Information will follow soon*


Security
---
If you discover any security related issues, please email rathes@aheenam.com or use the issue tracker of GitHub.

About
---
Aheenam is a small company from NRW, Germany creating custom digital solutions. Visit [our website](https://aheenam.com) to find out more about us.

License
---
The MIT License (MIT). Please see [License File](https://github.com/Aheenam/laravel-translatable/blob/master/LICENSE)
for more information.