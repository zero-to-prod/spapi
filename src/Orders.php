<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\SpapiOrders\SpapiOrders;

class Orders
{
    public $access_token;
    public $base_url;

    public function __construct(string $access_token, string $base_uri)
    {
        $this->access_token = $access_token;
        $this->base_url = $base_uri;
    }

    /**
     * Returns the order that you specify.
     *
     * @param $orderId
     *
     * @return array{
     *     info: array{
     *         url: string,
     *         content_type: string,
     *         http_code: int,
     *         header_size: int,
     *         request_size: int,
     *         filetime: int,
     *         ssl_verify_result: int,
     *         redirect_count: int,
     *         total_time: float,
     *         namelookup_time: float,
     *         connect_time: float,
     *         pretransfer_time: float,
     *         size_upload: int,
     *         size_download: int,
     *         speed_download: int,
     *         speed_upload: int,
     *         download_content_length: int,
     *         upload_content_length: int,
     *         starttransfer_time: float,
     *         redirect_time: float,
     *         redirect_url: string,
     *         primary_ip: string,
     *         certinfo: array,
     *         primary_port: int,
     *         local_ip: string,
     *         local_port: int,
     *         http_version: int,
     *         protocol: int,
     *         ssl_verifyresult: int,
     *         scheme: string,
     *         appconnect_time_us: int,
     *         connect_time_us: int,
     *         namelookup_time_us: int,
     *         pretransfer_time_us: int,
     *         redirect_time_us: int,
     *         starttransfer_time_us: int,
     *         total_time_us: int
     *     },
     *     error: string,
     *     headers: array{
     *         Server: string,
     *         Date: string,
     *         Content-Type: string,
     *         Content-Length: string,
     *         Connection: string,
     *         X-Amz-Rid: string,
     *         X-Amzn-Ratelimit-Limit: string,
     *         X-Amzn-Requestid: string,
     *         X-Amz-Apigw-Id: string,
     *         X-Amzn-Trace-Id: string,
     *         Vary: string,
     *         Strict-Transport-Security: string
     *     },
     *     response: array{
     *         payload: array{
     *             BuyerInfo: array{
     *                 BuyerEmail: string,
     *                 BuyerName: string
     *             },
     *             AmazonOrderId: string,
     *             EarliestShipDate: string,
     *             SalesChannel: string,
     *             OrderStatus: string,
     *             NumberOfItemsShipped: int,
     *             OrderType: string,
     *             IsPremiumOrder: bool,
     *             IsPrime: bool,
     *             FulfillmentChannel: string,
     *             NumberOfItemsUnshipped: int,
     *             HasRegulatedItems: bool,
     *             IsReplacementOrder: bool,
     *             IsSoldByAB: bool,
     *             LatestShipDate: string,
     *             ShipServiceLevel: string,
     *             IsISPU: bool,
     *             MarketplaceId: string,
     *             PurchaseDate: string,
     *             ShippingAddress: array{
     *                 StateOrRegion: string,
     *                 AddressLine1: string,
     *                 PostalCode: string,
     *                 City: string,
     *                 CountryCode: string,
     *                 Name: string
     *             },
     *             IsAccessPointOrder: bool,
     *             SellerOrderId: string,
     *             PaymentMethod: string,
     *             IsBusinessOrder: bool,
     *             OrderTotal: array{
     *                 CurrencyCode: string,
     *                 Amount: string
     *             },
     *             PaymentMethodDetails: array<string>,
     *             IsGlobalExpressEnabled: bool,
     *             LastUpdateDate: string,
     *             ShipmentServiceLevelCategory: string
     *         },
     *          errors: array{
     *              code: string,
     *              message: string,
     *              details: string
     *          }
     *     }
     * }
     * @link https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference#get-ordersv0ordersorderid
     */
    public function getOrder($orderId): array
    {
        return SpapiOrders::getOrder($this->base_url, $this->access_token, $orderId);
    }
}