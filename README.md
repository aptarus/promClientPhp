# php_prom

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


This library allows users to record and export stats about a program
in a way that [Prometheus](https://prometheus.io/) can make use of.
Statistics are stored locally in the filesystem; no additional service
is required to record the statistics.

## Install

Via Composer

``` bash
$ composer require aptarus/php_prom
```

## Usage

Client:

``` php
# TODO
```

Endpoint:

``` php
# TODO
```

Prometheus config:

```yaml
# TODO
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has
changed recently.

## Testing

``` bash
composer test
```

Preparing to test while developing:

```bash
sudo apt-get install php-codesniffer phpunit
```

Testing while developing:

```bash
phpcs --standard=psr2 src/
phpunit --coverage-text --coverage-clover=coverage.clover
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md)
for details.

## Security

If you discover any security related issues, please email
kevin.lyda@aptarus.com instead of using the issue tracker.

## Credits

- [Kevin Lyda][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.

[ico-version]: https://img.shields.io/packagist/v/aptarus/php_prom.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/aptarus/php_prom/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/aptarus/php_prom.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/aptarus/php_prom.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/aptarus/php_prom.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/aptarus/php_prom
[link-travis]: https://travis-ci.org/aptarus/php_prom
[link-scrutinizer]: https://scrutinizer-ci.com/g/aptarus/php_prom/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/aptarus/php_prom
[link-downloads]: https://packagist.org/packages/aptarus/php_prom
[link-author]: https://github.com/lyda
[link-contributors]: ../../contributors
