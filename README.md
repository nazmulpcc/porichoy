# A PHP Package to access https://porichoy.gov.bd services via their official api. 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/happihub/porichoy.svg?style=flat-square)](https://packagist.org/packages/happihub/porichoy)
[![Total Downloads](https://img.shields.io/packagist/dt/happihub/porichoy.svg?style=flat-square)](https://packagist.org/packages/happihub/porichoy)
![GitHub Actions](https://github.com/happihub/porichoy/actions/workflows/main.yml/badge.svg)

## Installation

You can install the package via composer:

```bash
composer require nazmulpcc/porichoy
```

## Usage

```php
$porichoy = new \Porichoy\Porichoy($api_host, $api_key); // sandbox mode
$porichoy = new \Porichoy\Porichoy($api_host, $api_key, false); // live mode
```

Or if you are using Laravel, you can use these env variables:

```text
PORICHOY_API_HOST=
PORICHOY_API_KEY=
```

You can also publish the config file if you need.
```bash
php artisan vendor:publish --tag=porichoy-config
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nazmul@happihub.com instead of using the issue tracker.

## Credits

-   [Nazmul Alam](https://github.com/nazmulpcc)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
