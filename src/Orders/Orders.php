<?php

namespace Zerotoprod\Spapi\Orders;

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

    public function getOrder($orderId): array
    {
        return SpapiOrders::getOrder($this->base_url.'/orders/v0/orders/'.$orderId, $this->access_token);
    }
}