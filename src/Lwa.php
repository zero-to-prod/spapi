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
    private $refreshToken;
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
        string $refreshToken,
        ?string $user_agent = null,
        string $endpoint = 'https://api.amazon.com/auth/o2/token'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
        $this->user_agent = $user_agent;
        $this->endpoint = $endpoint;
    }

    public static function from(
        string $clientId,
        string $clientSecret,
        string $refreshToken,
        ?string $user_agent = null,
        string $endpoint = 'https://api.amazon.com/auth/o2/token'
    ): self {
        return new self(
            $clientId,
            $clientSecret,
            $refreshToken,
            $user_agent,
            $endpoint
        );
    }

    public function refreshToken(): array
    {
        return SpapiLwa::refreshToken(
            $this->endpoint,
            $this->refreshToken,
            $this->clientId,
            $this->clientSecret,
            $this->user_agent
        );
    }
}