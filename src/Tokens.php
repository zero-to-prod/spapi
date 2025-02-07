<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\Spapi\Tokens\Orders;

/**
 * Call the Tokens API to get a Restricted Data Token (RDT) for restricted resources.
 *
 * The Selling Partner API for Tokens provides a secure way to access a customer's PII
 * (Personally Identifiable Information). You can call the Tokens API to get a
 * Restricted Data Token (RDT) for one or more restricted resources that you
 * specify. The RDT authorizes subsequent calls to restricted operations
 * that correspond to the restricted resources that you specified.
 *
 * For more information, see the Tokens API Use Case Guide.
 *
 * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
 */
class Tokens
{
    /**
     * @var string|null
     */
    private $targetApplication;

    /**
     * @var string
     */
    private $base_uri;
    /**
     * @var string
     */
    private $access_token;
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
     * @param  string       $access_token       The access token to create the RDT
     * @param  string|null  $targetApplication  The application ID for the target application to which access is being
     * @param  string       $base_uri           The URL for the api
     * @param  string|null  $user_agent         The user-agent for the request
     * @param  array        $options            Merge curl options
     *
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     */
    public function __construct(
        string $access_token,
        ?string $targetApplication = null,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ) {
        $this->access_token = $access_token;
        $this->targetApplication = $targetApplication;
        $this->user_agent = $user_agent;
        $this->base_uri = $base_uri;
        $this->options = $options;
    }

    /**
     * A helper method for instantiation.
     *
     * @param  string       $access_token       The access token to create the RDT
     * @param  string|null  $targetApplication  The application ID for the target application to which access is being
     * @param  string       $base_uri           The URL for the api
     * @param  string|null  $user_agent         The user-agent for the request
     * @param  array        $options            Merge curl options
     *
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     */
    public static function from(
        string $access_token,
        ?string $targetApplication = null,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ): self {
        return new self($access_token, $targetApplication, $base_uri, $user_agent, $options);
    }

    /**
     * Returns Restricted Data Tokens for the Orders API.
     */
    public function orders(): Orders
    {
        return new Orders(
            $this->access_token,
            $this->targetApplication,
            $this->base_uri,
            $this->user_agent,
            $this->options
        );
    }
}