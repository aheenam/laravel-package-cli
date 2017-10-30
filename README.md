*Do not use in production yet!*

Todo before first release
===
* ~~Refactor name validation into Generator *(and just catch in Command)*~~
* Add bin file
* ~~Add check if directory already exists~~
* ~~Add flag to force create~~
* Write Readme

Laravel Package CLI
===

Installation
---
You can install the package via composer:

```bash
composer require // add code here
```

If you are using Laravel in a version < 5.5, the service provider must be registered as a next step:

```php
// config/app.php
'providers' => [
    ...
    // add code here
];
```

Usage
---


Changelog
---
Check [CHANGELOG](CHANGELOG.md) for the changelog

Testing
---
To run tests use

    $ composer test

Contributing
---


Security
---
If you discover any security related issues, please email rathes@aheenam.com or use the issue tracker of GitHub.

About
---

License
---
The MIT License (MIT). Please see [License File](https://github.com/Aheenam/laravel-translatable/blob/master/LICENSE)
for more information.