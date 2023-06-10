# This package allows you to send events to refodev while a session is being recorded

[![Latest Version on Packagist](https://img.shields.io/packagist/v/refodev/refodev-php.svg?style=flat-square)](https://packagist.org/packages/refodev/refodev-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/refodev/refodev-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/refodev/refodev-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/refodev/refodev-php.svg?style=flat-square)](https://packagist.org/packages/refodev/refodev-php)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/refodev-php.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/refodev-php)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require refodev/refodev-php
```

## Usage

```php
$skeleton = new Refodev\RefodevClient();
echo $skeleton->echoPhrase('Hello, Refodev!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [refodev](https://github.com/refodev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
