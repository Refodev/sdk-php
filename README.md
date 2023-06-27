# This package allows you to send events to devqaly while a session is being recorded

[![Latest Version on Packagist](https://img.shields.io/packagist/v/devqaly/devqaly-php.svg?style=flat-square)](https://packagist.org/packages/devqaly/devqaly-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/devqaly/devqaly-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/devqaly/devqaly-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/devqaly/devqaly-php.svg?style=flat-square)](https://packagist.org/packages/devqaly/devqaly-php)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require devqaly/devqaly-php
```

## Usage

```php
$devqaly = new Devqaly\DevqalyClient();

$sessionId = "5b03dfdf-4ad4-40ef-a67e-62b738ab76b6";
$sessionSecret = "icURAAVjCuLFaYEgUdXaW1dkDcqWNZ7bo9J1ibjfhI28xVkzQUdTRCZcsjd9";

$devqaly->createDatabaseEventTransaction($sessionId, $sessionSecret, [
    'sql' => $sql,
    'executionTimeInMilliseconds' => $executionTimeInMilliseconds
]);

$devqaly->createLogEvent($sessionId, $sessionSecret, [
    'level' => $level, // can be 'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'informational' or 'debug'
    'log' => $log
]);
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

- [devqaly](https://github.com/devqaly)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
