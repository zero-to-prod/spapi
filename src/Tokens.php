<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\SpapiTokens\SpapiTokens;

class Tokens
{
    /**
     * @var array
     */
    public $dataElements;
    /**
     * @var string|null
     */
    public $delegatee;

    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var string
     */
    public $access_token;
    /**
     * @var string|null
     */
    private $user_agent;

    public function __construct(
        string $access_token,
        array $dataElements = [],
        ?string $delegatee = null,
        ?string $user_agent = null,
        string $endpoint = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken'
    ) {
        $this->access_token = $access_token;
        $this->dataElements = $dataElements;
        $this->delegatee = $delegatee;
        $this->user_agent = $user_agent;
        $this->endpoint = $endpoint;
    }

    public static function from(
        string $access_token,
        array $dataElements = [],
        ?string $delegatee = null,
        ?string $user_agent = null,
        string $endpoint = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken'
    ): self {
        return new self($access_token, $dataElements, $delegatee, $user_agent, $endpoint);
    }

    public function order(string $order_id): array
    {
        return SpapiTokens::createRestrictedDataToken(
            $this->access_token,
            '/orders/v0/orders/'.$order_id,
            $this->dataElements,
            $this->delegatee,
            $this->user_agent,
            $this->endpoint
        );
    }

    public function orders(): array
    {
        return SpapiTokens::createRestrictedDataToken(
            $this->access_token,
            '/orders/v0/orders',
            $this->dataElements,
            $this->delegatee,
            $this->user_agent,
            $this->endpoint
        );
    }
}