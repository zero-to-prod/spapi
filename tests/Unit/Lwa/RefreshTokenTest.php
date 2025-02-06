<?php

declare(strict_types=1);

namespace Unit\Lwa;

use Tests\TestCase;
use Zerotoprod\Spapi\Lwa;

class RefreshTokenTest extends TestCase
{

    /**
     * @test
     */
    public function refreshToken(): void
    {
        $response = Lwa::from(
            'client_id',
            'client_secret',
            'https://httpbin.org/post',
            'user-agent'
        )->refreshToken('refresh_token');

        self::assertEquals(200, $response['info']['http_code']);
        self::assertEquals('client_id', $response['response']['form']['client_id']);
        self::assertEquals('client_secret', $response['response']['form']['client_secret']);
        self::assertEquals('refresh_token', $response['response']['form']['grant_type']);
        self::assertEquals('refresh_token', $response['response']['form']['refresh_token']);
        self::assertEquals('user-agent', $response['response']['form']['user-agent']);
    }
}