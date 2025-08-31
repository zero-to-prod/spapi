<?php

declare(strict_types=1);

namespace Zerotoprod\Spapi;

use Zerotoprod\Container\Container;
use Zerotoprod\Spapi\Contracts\SpapiInterface;
use Zerotoprod\Spapi\Support\Testing\SpapiFake;
use Zerotoprod\SpapiOrders\Contracts\SpapiOrdersInterface;
use Zerotoprod\SpapiOrders\SpapiOrders;

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
class Spapi implements SpapiInterface
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
     * Instantiate this class.
     *
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Curl options.
     *
     * @see  https://developer-docs.amazon.com/sp-api
     * @link https://github.com/zero-to-prod/spapi
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
     * A helper method for instantiation.
     *
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Curl options.
     *
     * @see  https://developer-docs.amazon.com/sp-api
     * @link https://github.com/zero-to-prod/spapi
     */
    public static function from(
        string $access_token,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com',
        ?string $user_agent = null,
        array $options = []
    ): SpapiInterface {
        return Container::getInstance()->has(SpapiFake::class)
            ? Container::getInstance()->get(SpapiFake::class)
            : new self(
                $access_token,
                $base_uri,
                $user_agent,
                $options
            );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi
     */
    public function orders(): SpapiOrdersInterface
    {
        return SpapiOrders::from(
            $this->access_token,
            $this->base_uri,
            $this->user_agent,
            $this->options
        );
    }
}