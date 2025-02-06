<?php
/**
 * @noinspection PhpStrictTypeCheckingInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

namespace Unit\Lwa;

use Tests\TestCase;
use Zerotoprod\Spapi\Lwa;

class ClientCredentialsTest extends TestCase
{

    /** @test */
    public function clientCredentials(): void
    {
        $response = Lwa::from(
            'client_id',
            'client_secret',
            'https://httpbin.org/post',
            'user-agent'
        )->clientCredentials('scope');

        self::assertEquals(200, $response['info']['http_code']);
        self::assertEquals('client_id', $response['response']['form']['client_id']);
        self::assertEquals('client_secret', $response['response']['form']['client_secret']);
        self::assertEquals('client_credentials', $response['response']['form']['grant_type']);
        self::assertEquals('scope', $response['response']['form']['scope']);
        self::assertEquals('user-agent', $response['response']['form']['user-agent']);
    }
}