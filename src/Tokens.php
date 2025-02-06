<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\SpapiTokens\SpapiTokens;

class Tokens
{
    /**
     * @var array
     */
    private $dataElements;
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

    public function __construct(
        string $access_token,
        array $dataElements = [],
        ?string $targetApplication = null,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ) {
        $this->access_token = $access_token;
        $this->dataElements = $dataElements;
        $this->targetApplication = $targetApplication;
        $this->user_agent = $user_agent;
        $this->base_uri = $base_uri;
        $this->options = $options;
    }

    public static function from(
        string $access_token,
        array $dataElements = [],
        ?string $targetApplication = null,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ): self {
        return new self($access_token, $dataElements, $targetApplication, $base_uri, $user_agent, $options);
    }

    /**
     * Creates a Restricted Data Token.
     *
     * @param  string  $order_id  Amazon Order ID
     * @param  array   $options   Merge curl options
     *
     * @return array{
     *  info: array{
     *      url: string,
     *      content_type: string,
     *      http_code: int,
     *      header_size: int,
     *      request_size: int,
     *      filetime: int,
     *      ssl_verify_result: int,
     *      redirect_count: int,
     *      total_time: float,
     *      namelookup_time: float,
     *      connect_time: float,
     *      pretransfer_time: float,
     *      size_upload: int,
     *      size_download: int,
     *      speed_download: int,
     *      speed_upload: int,
     *      download_content_length: int,
     *      upload_content_length: int,
     *      starttransfer_time: float,
     *      redirect_time: float,
     *      redirect_url: string,
     *      primary_ip: string,
     *      certinfo: array,
     *      primary_port: int,
     *      local_ip: string,
     *      local_port: int,
     *      http_version: int,
     *      protocol: int,
     *      ssl_verifyresult: int,
     *      scheme: string,
     *      appconnect_time_us: int,
     *      connect_time_us: int,
     *      namelookup_time_us: int,
     *      pretransfer_time_us: int,
     *      redirect_time_us: int,
     *      starttransfer_time_us: int,
     *      total_time_us: int
     *  },
     *  error: string,
     *  headers: array{
     *      Server: string,
     *      Date: string,
     *      Content-Type: string,
     *      Content-Length: string,
     *      Connection: string,
     *      'x-amz-rid': string,
     *      'x-amzn-RateLimit-Limit': string,
     *      'x-amzn-RequestId': string,
     *      'x-amz-apigw-id': string,
     *      'X-Amzn-Trace-Id': string,
     *      Vary: string,
     *      'Strict-Transport-Security': string
     *  },
     *  response: array{
     *      expiresIn: int,
     *      restrictedDataToken: string
     *  }
     */
    public function order(string $order_id, array $options = []): array
    {
        return SpapiTokens::createRestrictedDataToken(
            $this->access_token,
            '/orders/v0/orders/'.$order_id,
            $this->dataElements,
            $this->targetApplication,
            $this->base_uri,
            $this->user_agent,
            array_merge($this->options, $options)
        );
    }

    /**
     * Creates a Restricted Data Token.
     *
     * @param  array  $options  Merge curl options
     *
     * @return array{
     *  info: array{
     *      url: string,
     *      content_type: string,
     *      http_code: int,
     *      header_size: int,
     *      request_size: int,
     *      filetime: int,
     *      ssl_verify_result: int,
     *      redirect_count: int,
     *      total_time: float,
     *      namelookup_time: float,
     *      connect_time: float,
     *      pretransfer_time: float,
     *      size_upload: int,
     *      size_download: int,
     *      speed_download: int,
     *      speed_upload: int,
     *      download_content_length: int,
     *      upload_content_length: int,
     *      starttransfer_time: float,
     *      redirect_time: float,
     *      redirect_url: string,
     *      primary_ip: string,
     *      certinfo: array,
     *      primary_port: int,
     *      local_ip: string,
     *      local_port: int,
     *      http_version: int,
     *      protocol: int,
     *      ssl_verifyresult: int,
     *      scheme: string,
     *      appconnect_time_us: int,
     *      connect_time_us: int,
     *      namelookup_time_us: int,
     *      pretransfer_time_us: int,
     *      redirect_time_us: int,
     *      starttransfer_time_us: int,
     *      total_time_us: int
     *  },
     *  error: string,
     *  headers: array{
     *      Server: string,
     *      Date: string,
     *      Content-Type: string,
     *      Content-Length: string,
     *      Connection: string,
     *      'x-amz-rid': string,
     *      'x-amzn-RateLimit-Limit': string,
     *      'x-amzn-RequestId': string,
     *      'x-amz-apigw-id': string,
     *      'X-Amzn-Trace-Id': string,
     *      Vary: string,
     *      'Strict-Transport-Security': string
     *  },
     *  response: array{
     *      expiresIn: int,
     *      restrictedDataToken: string
     *  }
     */
    public function orders(array $options = []): array
    {
        return SpapiTokens::createRestrictedDataToken(
            $this->access_token,
            '/orders/v0/orders',
            $this->dataElements,
            $this->targetApplication,
            $this->base_uri,
            $this->user_agent,
            array_merge($this->options, $options)
        );
    }
}