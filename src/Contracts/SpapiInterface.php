<?php

namespace Zerotoprod\Spapi\Contracts;

use Zerotoprod\SpapiOrders\Contracts\SpapiOrdersInterface;

/**
 * A PHP client library for Amazon's Selling Partner API.
 *
 * The Selling Partner API (SP-API) is a REST-based API
 * that helps Amazon selling partners programmatically
 * access their data on orders, shipments, payments,
 * and much more. Applications using the SP-API can
 * increase selling efficiency, reduce labor
 * requirements, and improve response time
 * to customers, helping selling partners
 * grow their businesses.
 *
 * @see  https://developer-docs.amazon.com/sp-api
 * @link https://github.com/zero-to-prod/spapi
 */
interface SpapiInterface
{
    /**
     * Use the Orders Selling Partner API to programmatically retrieve order information. With this API,
     * you can develop fast, flexible, and custom applications to manage order synchronization, perform
     * order research, and create demand-based decision support tools.
     *
     * @see  https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference
     * @link https://github.com/zero-to-prod/spapi
     */
    public function orders(): SpapiOrdersInterface;
}