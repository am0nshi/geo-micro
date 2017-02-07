# Geo Cashier Microservice

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Lumen-based microservice realization

## Usage

GET /v1/whitelist/ip
POST /v1/whitelist/ip {ip:'127.0.0.1'}
DELETE /v1/whitelist/ip/$ip 127.0.0.1

GET /v1/whitelist/customer
POST /v1/whitelist/customer {customerId:'12345',FullName:'Some Name',ExpirationDate:'26.12.2018'}
DELETE /v1/whitelist/ip/$customerId

GET /v1/whitelist/
POST /v1/whitelist/customer {ip:'127.0.0.1',customerId:'12345',FullName:'Some Name',ExpirationDate:'26.12.2018'}
DELETE /v1/whitelist/ip/$customerId

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
