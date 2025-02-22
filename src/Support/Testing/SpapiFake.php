<?php

namespace Zerotoprod\Spapi\Support\Testing;

use Zerotoprod\Container\Container;
use Zerotoprod\Spapi\Contracts\SpapiInterface;
use Zerotoprod\SpapiOrders\Contracts\SpapiOrdersInterface;
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersFake;

class SpapiFake implements SpapiInterface
{
    private $response;

    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    public static function fake(array $response = [], ?SpapiInterface $fake = null): SpapiInterface
    {
        Container::getInstance()
            ->instance(
                __CLASS__,
                $instance = $fake ?? new self($response)
            );

        return $instance;
    }

    public function orders(): SpapiOrdersInterface
    {
        return new SpapiOrdersFake($this->response);
    }
}