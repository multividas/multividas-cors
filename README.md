<div align="center">

# Multividas CORS Middleware

[![Tests](https://github.com/multividas/multividas-cors/actions/workflows/tests.yml/badge.svg)](https://github.com/multividas/multividas-cors/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/multividas/multividas-cors.svg?style=flat-square)](https://packagist.org/packages/multividas/multividas-cors)
[![License](https://img.shields.io/github/license/multividas/multividas-cors?style=flat-square)](https://github.com/multividas/multividas-cors/blob/main/LICENSE)

</div>

Multividas CORS middleware is a package designed to handle Cross-Origin Resource Sharing (CORS).

## Installation

Require this package with composer.

```shell
composer require multividas/multividas-cors
```

## Service Provider

To utilize the CORS middleware, add the **AllowCrossOriginServiceProvider** to the providers array in **config/app.php**:

```php
\Multividas\AllowCrossOrigin\Providers\AllowCrossOriginServiceProvider::class
```

## Configuration

To configure Multividas CORS middleware, copy the package configuration to your local configuration using the publish command:

```sh
php artisan vendor:publish --tag=multividas-cors-config
```

## 🤝 Contributing

Please read the [contributing guide](https://github.com/multividas/.github/blob/main/CONTRIBUTING.md).

## 🛡️ Security Issues

If you discover a security vulnerability within Multividas, we would appreciate your help in disclosing it to us responsibly, please check out our [security issues guidelines](https://github.com/multividas/.github/blob/main/SECURITY.md).

## 🛡️ License

Licensed under the [MIT license](https://github.com/multividas/.github/blob/main/LICENSE).

---

> Email: multividasdotcom@gmail.com
