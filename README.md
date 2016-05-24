# promClientPhp

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
$ composer require aptarus/promClientPhp
```

## Usage

Add this to `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/aptarus/promClientPhp.git"
        }
    ],
    "require": {
        "php" : "~5.5|~7.0",
        "aptarus/promClientPhp": "dev-master"
    }
}
```

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

### Test prerequisites

Need to install the following on Ubuntu for testing to work:

```bash
sudo apt-get install php-codesniffer phpunit php5-sqlite
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md)
for details.

### Contribution notes

This package is based on [the PHP league](http://thephpleague.com/)'s
[skeleton](https://github.com/thephpleague/skeleton). From time to
time it's not a bad idea to try merging in the skeleton project in case
there are new bits of the php ecosystem this project might benefit from.
To do this just run:

```bash
git fetch git@github.com:thephpleague/skeleton.git
```

## Security

If you discover any security related issues, please email
kevin.lyda@aptarus.com instead of using the issue tracker.

## Credits

- [Kevin Lyda][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.

[ico-version]: https://img.shields.io/packagist/v/aptarus/promClientPhp.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/aptarus/promClientPhp/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/aptarus/promClientPhp.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/aptarus/promClientPhp.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/aptarus/promClientPhp.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/aptarus/promClientPhp
[link-travis]: https://travis-ci.org/aptarus/promClientPhp
[link-scrutinizer]: https://scrutinizer-ci.com/g/aptarus/promClientPhp/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/aptarus/promClientPhp
[link-downloads]: https://packagist.org/packages/aptarus/promClientPhp
[link-author]: https://github.com/lyda
[link-contributors]: https://github.com/aptarus/promClientPhp/graphs/contributors
