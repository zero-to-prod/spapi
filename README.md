# Zerotoprod\Spapi

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi/test.yml?label=test)](https://github.com/zero-to-prod/spapi/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/spapi?color=blue)](https://packagist.org/packages/zero-to-prod/spapi/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/spapi.svg?color=purple)](https://packagist.org/packages/zero-to-prod/spapi/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/spapi?color=f28d1a)](https://packagist.org/packages/zero-to-prod/spapi)
[![License](https://img.shields.io/packagist/l/zero-to-prod/spapi?color=pink)](https://github.com/zero-to-prod/spapi/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/spapi.svg)](https://wakatime.com/badge/github/zero-to-prod/spapi)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/spapi?branch=main)](https://hitsofcode.com/github/zero-to-prod/spapi/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Authentication](#authentication)
    - [Refresh Token](#refresh-token)
    - [Client Credentials](#client-credentials)
    - [Restricted Data Token](#restricted-data-token)
- [Orders Api](#orders-api)
    - [getOrder](#getorder)
    - [getOrders](#getorders)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

A PHP client library for Amazon's Selling Partner API.

## Requirements

- PHP 7.1 or higher.

## Installation

Install `Zerotoprod\Spapi` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/spapi
```

This will add the package to your project’s dependencies and create an autoloader entry for it.

## Authentication

### Refresh Token

```php
use Zerotoprod\Spapi\Lwa;

$access_token = Lwa::from(
    'amzn1.application-oa2-client.xxx',
    'amzn1.oa2-cs.v1.xxx',
    'Atzr|xxx'
)->refreshToken()['response']['access_token'];
```

### Client Credentials

```php
use Zerotoprod\Spapi\Lwa;

$access_token = Lwa::from(
    'amzn1.application-oa2-client.xxx',
    'amzn1.oa2-cs.v1.xxx',
    'Atzr|xxx'
)->clientCredentials('scope')['response']['access_token'];
```

### Restricted Data Token

```php
// Use the Tokens API to get an RDT (Restricted Data Token)
$access_token = Tokens::from(
    'access_token',
    ['buyerInfo', 'shippingAddress'],
    'amzn1.sp.solution.xxx'
)->order('123-1234567-1234567')['response']['restrictedDataToken'];
```

## Orders Api

### getOrder

Get an order.

```php
use Zerotoprod\Spapi\Spapi;

// Create an Instance of the Spapi service with an access token. 
$Spapi = Spapi::from($access_token);

// Access the orders api and get an order.
$Order = $Spapi->orders()->getOrder('111-5803802-7417822');

// Access the order details or an error.
echo $Order['response']['payload']['AmazonOrderId'];
echo $Order['response']['errors']['code'];
```

### getOrders

Get orders.

```php
use Zerotoprod\Spapi\Spapi;

// Create an Instance of the Spapi service with an access token. 
$Spapi = Spapi::from($access_token);

// Access the orders api and get an order.
$Order = $Spapi->orders()->getOrders('111-5803802-7417822');

// Access the order details or an error.
echo $Order['response']['payload']['Orders'][0]['AmazonOrderId']
echo $Order['response']['errors']['code'];
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.