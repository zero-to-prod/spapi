# Zerotoprod\Spapi

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi/test.yml?label=test)](https://github.com/zero-to-prod/spapi/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/spapi/actions)
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
    - [getOrders](#getorders)
    - [getOrder](#getorder)
    - [getOrderBuyerInfo](#getorderbuyerinfo)
    - [getOrderAddress](#getorderaddress)
    - [getOrderItems](#getorderitems)
- [Examples](#examples)
    - [Get an order with a Restricted Data Token](#get-an-order-with-a-restricted-data-token)
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

Use this for calling operations that require authorization from a selling partner. All operations that are not grantless operations require
authorization from a selling partner. When specifying this value, include the rrefresh_token parameter.

```php
use Zerotoprod\Spapi\Lwa;
use Zerotoprod\SpapiLwa\SpapiLwa;

$response = SpapiLwa::from(
    'amzn1.application-oa2-client.xxx', // client_id
    'amzn1.oa2-cs.v1.xxx'               // client_secret
)->refreshToken('refresh_token');       // The LWA refresh token. Get this value when the selling partner authorizes your application

$access_token = $response['response']['access_token'];
```

### Client Credentials

Use this for calling grantless operations. When specifying this value, include the scope parameter.

```php
use Zerotoprod\Spapi\Lwa;
use Zerotoprod\SpapiLwa\SpapiLwa;

$response = SpapiLwa::from(
    'amzn1.application-oa2-client.xxx', // client_id
    'amzn1.oa2-cs.v1.xxx',              // client_secret
)->clientCredentials('scope');

$access_token = $response['response']['access_token'];
```

### Restricted Data Token

Use the access token received from [Login With Amazon](#refresh-token);

```php
use Zerotoprod\Spapi\Tokens;
use \Zerotoprod\SpapiRdt\SpapiRdt;

// Use the SpapiRdt API to get an RDT (Restricted Data Token)
$response = SpapiRdt::from(
    'access_token',                     // Access token received from LWA
    'amzn1.sp.solution.xxx'             // Target Application
)
    ->orders()
    ->getOrder(
        '123-1234567-1234567',           // Amazon Order Id
        ['buyerInfo', 'shippingAddress'] // Restricted Data Elements to Access
);

$access_token = $response['response']['restrictedDataToken'];
```

## Spapi

Instantiate the Spapi from an `access_token` generated from [Login With Amazon](#refresh-token) or a [Restricted Data Token](#restricted-data-token)

```php
use Zerotoprod\Spapi\Spapi;

$Spapi = Spapi::from($access_token);
```

## Orders Api

Programmatically retrieve order information.

Use the Orders Selling Partner API to programmatically retrieve order information. With this API, you can develop fast, flexible, and custom
applications to manage order synchronization, perform order research, and create demand-based decision support tools.

### getOrders

Returns orders that are created or updated during the specified time period. If you want to return specific types of orders, you can apply filters to
your request. NextToken doesn't affect any filters that you include in your request; it only impacts the pagination for the filtered orders response.

```php
use Zerotoprod\Spapi\Spapi;

// Access the orders api and get orders.
$Orders = Spapi::from($access_token)
    ->orders()
    ->getOrders(
      ['MarketplaceIds']
      'CreatedAfter'
      'CreatedBefore'
      'LastUpdatedAfter'
      'LastUpdatedBefore'
      '[OrderStatuses']
      ['FulfillmentChannels']
      ['PaymentMethods']
      'BuyerEmail'
      'SellerOrderId'
      MaxResultsPerPage
      ['EasyShipShipmentStatuses']
      ['ElectronicInvoiceStatuses']
      'NextToken'
      ['AmazonOrderIds']
      'ActualFulfillmentSupplySourceId'
      'IsISPU'
      'StoreChainStoreId'
      'EarliestDeliveryDateBefore'
      'EarliestDeliveryDateAfter'
      'LatestDeliveryDateBefore'
      'LatestDeliveryDateAfter'
      ['curl_options'],
);

// Access the orders.
echo $Orders['response']['payload']['Orders'][0]['AmazonOrderId']

// Access errors.
echo $Orders['response']['errors']['code'];
```

### getOrder

Returns the order that you specify.

```php
use Zerotoprod\Spapi\Spapi;

$Order = Spapi::from($access_token)
    ->orders()
    ->getOrder('111-5803802-7417822', ['curl_options']);

// Access the order.
echo $Order['response']['payload']['AmazonOrderId'];

// Access errors.
echo $Order['response']['errors']['code'];
```

### getOrderBuyerInfo

Returns buyer information for the order that you specify.

```php
use Zerotoprod\Spapi\Spapi;

$OrderBuyerInfo = Spapi::from($access_token)
    ->orders()
    ->getOrderBuyerInfo('111-5803802-7417822', ['curl_options']);

// Access the buyer info.
echo $OrderBuyerInfo['response']['payload']['BuyerName'];

// Access errors.
echo $OrderBuyerInfo['response']['errors']['code'];
```

### getOrderAddress

Retrieves the shipping address for the specified order

```php
use Zerotoprod\Spapi\Spapi;

$OrderBuyerInfo = Spapi::from($access_token)
    ->orders()
    ->getOrderAddress('111-5803802-7417822', ['curl_options']);

// Access the buyer info.
echo $OrderBuyerInfo['response']['payload']['BuyerName'];

// Access errors.
echo $OrderBuyerInfo['response']['errors']['code'];
```

### getOrderItems

Returns detailed order item information for the order that you specify. If NextToken is provided, it's used to retrieve the next page of order items.

Note: When an order is in the Pending state (the order has been placed but payment has not been authorized), the getOrderItems operation does not
return information about pricing, taxes, shipping charges, gift status or promotions for the order items in the order. After an order leaves the
Pending state (this occurs when payment has been authorized) and enters the Unshipped, Partially Shipped, or Shipped state, the getOrderItems
operation returns information about pricing, taxes, shipping charges, gift status and promotions for the order items in the order.

```php
use Zerotoprod\Spapi\Spapi;


$Order = Spapi::from($access_token)
    ->orders()
    ->getOrderItems('111-5803802-7417822', ['curl_options']);

// Access the order.
echo $Order['response']['payload']['OrderItems'][0]['SellerSKU'];

// Access errors.
echo $Order['response']['errors']['code'];
```

## Examples

### Get an order with a Restricted Data Token

```php
use Zerotoprod\SpapiLwa\SpapiLwa;
use Zerotoprod\Spapi\Spapi;
use \Zerotoprod\SpapiRdt\SpapiRdt;

$lwa = SpapiLwa::from('amzn1.application-oa2-client.xxx','amzn1.oa2-cs.v1.xxx')
    ->refreshToken('Atzr|xxx');

$rdt = SpapiRdt::from($lwa['response']['access_token'],'amzn1.sp.solution.xxx')
    ->orders()
    ->getOrder('123-1234567-1234567', ['buyerInfo', 'shippingAddress']);

$response = Spapi::from($rdt['response']['restrictedDataToken'])
    ->orders()
    ->getOrder('111-5803802-7417822');

$Order = $response['response']['payload'];
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.
