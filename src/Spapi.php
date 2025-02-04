<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\Spapi\Orders\Orders;

class Spapi
{
    public $access_token;
    public $endpoint;

    public function __construct(string $access_token, string $endpoint)
    {
        $this->access_token = $access_token;
        $this->endpoint = $endpoint;
    }

    public static function config(string $access_token, string $endpoint): self
    {
        return new self($access_token, $endpoint);
    }

    public function orders(): Orders
    {
        return new Orders($this->access_token, $this->endpoint);
    }
}