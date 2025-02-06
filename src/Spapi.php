<?php

declare(strict_types=1);

namespace Zerotoprod\Spapi;

/**
 * The Selling Partner API (SP-API) is a REST-based API
 * that helps Amazon selling partners programmatically
 * access their data on orders, shipments, payments,
 * and much more. Applications using the SP-API can
 * increase selling efficiency, reduce labor
 * requirements, and improve response time
 * to customers, helping selling partners
 * grow their businesses.
 *
 * @link https://developer-docs.amazon.com/sp-api
 */
class Spapi
{
    /**
     * @var string
     */
    private $access_token;
    /**
     * @var string
     */
    private $base_uri;
    /**
     * @var string|null
     */
    private $user_agent;
    /**
     * @var array
     */
    private $options;

    /**
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Curl options.
     *
     * @link https://developer-docs.amazon.com/sp-api
     */
    public function __construct(
        string $access_token,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com',
        ?string $user_agent = null,
        array $options = []
    ) {
        $this->access_token = $access_token;
        $this->base_uri = $base_uri;
        $this->user_agent = $user_agent;
        $this->options = $options;
    }

    /**
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Curl options.
     *
     * @link https://developer-docs.amazon.com/sp-api
     */
    public static function from(
        string $access_token,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com',
        ?string $user_agent = null,
        array $options = []
    ): self {
        return new self(
            $access_token,
            $base_uri,
            $user_agent,
            $options
        );
    }

    /**
     * Use the Orders Selling Partner API to programmatically retrieve order information. With this API,
     * you can develop fast, flexible, and custom applications to manage order synchronization, perform
     * order research, and create demand-based decision support tools.
     *
     * @link https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference#get-ordersv0ordersorderid
     */
    public function orders(): Orders
    {
        return new Orders(
            $this->access_token,
            $this->base_uri,
            $this->user_agent,
            $this->options
        );
    }
}