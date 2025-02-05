<?php

namespace Zerotoprod\Spapi;

use Zerotoprod\SpapiLwa\SpapiLwa;

class Lwa
{
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $clientSecret;
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var string|null
     */
    private $user_agent;

    public function __construct(
        string $clientId,
        string $clientSecret,
        ?string $user_agent = null,
        string $base_uri = 'https://api.amazon.com/auth/o2/token'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->user_agent = $user_agent;
        $this->endpoint = $base_uri;
    }

    public static function from(
        string $clientId,
        string $clientSecret,
        ?string $user_agent = null,
        string $endpoint = 'https://api.amazon.com/auth/o2/token'
    ): self {
        return new self(
            $clientId,
            $clientSecret,
            $user_agent,
            $endpoint
        );
    }

    /**
     * Use this for calling operations that require authorization from a selling partner. All operations that are not grantless operations require authorization from a selling partner. When specifying this value, include the rrefresh_token parameter.
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
     *         'x-amz-rid': string,
     *         'x-amzn-RequestId': string,
     *         'X-Amz-Date': string,
     *         'Cache-Control': string,
     *         Pragma: string,
     *         Vary: string,
     *         'Strict-Transport-Security': string
     *     },
     *     response: array{
     *         access_token: string,
     *         refresh_token: string,
     *         token_type: string,
     *         expires_in: int
     *     }
     * }
     *
     * @link https://developer-docs.amazon.com/sp-api/docs/connecting-to-the-selling-partner-api#step-1-request-a-login-with-amazon-access-token
     */
    public function refreshToken($refreshToken): array
    {
        return SpapiLwa::refreshToken(
            $this->endpoint,
            $refreshToken,
            $this->clientId,
            $this->clientSecret,
            $this->user_agent
        );
    }

    /**
     * Use this for calling grantless operations. When specifying this value, include the scope parameter.
     *
     * @return array{
     *      info: array{
     *          url: string,
     *          content_type: string,
     *          http_code: int,
     *          header_size: int,
     *          request_size: int,
     *          filetime: int,
     *          ssl_verify_result: int,
     *          redirect_count: int,
     *          total_time: float,
     *          namelookup_time: float,
     *          connect_time: float,
     *          pretransfer_time: float,
     *          size_upload: int,
     *          size_download: int,
     *          speed_download: int,
     *          speed_upload: int,
     *          download_content_length: int,
     *          upload_content_length: int,
     *          starttransfer_time: float,
     *          redirect_time: float,
     *          redirect_url: string,
     *          primary_ip: string,
     *          certinfo: array,
     *          primary_port: int,
     *          local_ip: string,
     *          local_port: int,
     *          http_version: int,
     *          protocol: int,
     *          ssl_verifyresult: int,
     *          scheme: string,
     *          appconnect_time_us: int,
     *          connect_time_us: int,
     *          namelookup_time_us: int,
     *          pretransfer_time_us: int,
     *          redirect_time_us: int,
     *          starttransfer_time_us: int,
     *          total_time_us: int
     *      },
     *      error: string,
     *      headers: array{
     *          Server: string,
     *          Date: string,
     *          Content-Type: string,
     *          Content-Length: string,
     *          Connection: string,
     *          'x-amz-rid': string,
     *          'x-amzn-RequestId': string,
     *          'X-Amz-Date': string,
     *          'Cache-Control': string,
     *          Pragma: string,
     *          Vary: string,
     *          'Strict-Transport-Security': string
     *      },
     *      response: array{
     *          access_token: string,
     *          scope: string,
     *          token_type: string,
     *          expires_in: int
     *      }
     *  }
     * @link https://developer-docs.amazon.com/sp-api/docs/connecting-to-the-selling-partner-api#step-1-request-a-login-with-amazon-access-token
     */
    public function clientCredentials($scope): array
    {
        return SpapiLwa::clientCredentials(
            $this->endpoint,
            $scope,
            $this->clientId,
            $this->clientSecret,
            $this->user_agent
        );
    }
}