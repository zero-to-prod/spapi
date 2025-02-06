<?php
/**
 * @noinspection PhpStrictTypeCheckingInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpExpressionResultUnusedInspection
 * @noinspection PhpVariableIsUsedOnlyInClosureInspection
 */

declare(strict_types=1);

namespace Tests\Unit\Lwa;

use Mockery;
use Tests\TestCase;
use TypeError;
use Zerotoprod\Spapi\Lwa;
use Zerotoprod\SpapiLwa\SpapiLwa;

class LwaTest extends TestCase
{
    private const DEFAULT_BASE_URI = 'https://api.amazon.com/auth/o2/token';
    private const TEST_CLIENT_ID = 'test-client-id';
    private const TEST_CLIENT_SECRET = 'test-client-secret';
    private const TEST_USER_AGENT = 'CustomUserAgent/1.0';
    private const TEST_BASE_URI = 'https://custom-auth.amazon.com/auth/o2/token';
    private const TEST_REFRESH_TOKEN = 'test-refresh-token';
    private const TEST_SCOPE = 'test-scope';

    /**
     * @test
     */
    public function client_credentials(): void
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

    /**
     * @test
     */
    public function it_creates_instance_with_minimal_parameters(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->assertInstanceOf(Lwa::class, $lwa);
    }

    /**
     * @test
     */
    public function it_creates_instance_with_all_parameters(): void
    {
        $options = ['timeout' => 30];
        $lwa = new Lwa(
            self::TEST_CLIENT_ID,
            self::TEST_CLIENT_SECRET,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $options
        );

        $this->assertInstanceOf(Lwa::class, $lwa);
    }

    /**
     * @test
     */
    public function it_merges_options_in_refresh_token(): void
    {
        $instanceOptions = ['timeout' => 30];
        $methodOptions = ['retry' => true];
        $expectedOptions = array_merge($instanceOptions, $methodOptions);

        $expectedResponse = ['access_token' => 'new-token'];

        $this->mockSpapiLwaStaticMethod('refreshToken', $expectedResponse, function ($uri, $token, $clientId, $clientSecret, $userAgent, $options) use ($expectedOptions) {
            $this->assertEquals($expectedOptions, $options);

            return true;
        });

        $lwa = new Lwa(
            self::TEST_CLIENT_ID,
            self::TEST_CLIENT_SECRET,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $instanceOptions
        );

        $response = $lwa->refreshToken(self::TEST_REFRESH_TOKEN, $methodOptions);
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function it_merges_options_in_client_credentials(): void
    {
        $instanceOptions = ['timeout' => 30];
        $methodOptions = ['retry' => true];
        $expectedOptions = array_merge($instanceOptions, $methodOptions);

        $expectedResponse = ['access_token' => 'client-token'];

        $this->mockSpapiLwaStaticMethod('clientCredentials', $expectedResponse, function ($uri, $scope, $clientId, $clientSecret, $userAgent, $options) use ($expectedOptions) {
            $this->assertEquals($expectedOptions, $options);

            return true;
        });

        $lwa = new Lwa(
            self::TEST_CLIENT_ID,
            self::TEST_CLIENT_SECRET,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $instanceOptions
        );

        $response = $lwa->clientCredentials(self::TEST_SCOPE, $methodOptions);
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function it_overrides_instance_options_with_method_options(): void
    {
        $instanceOptions = ['timeout' => 30, 'retry' => false];
        $methodOptions = ['retry' => true];
        $expectedOptions = ['timeout' => 30, 'retry' => true];

        $this->mockSpapiLwaStaticMethod('refreshToken', [], function ($uri, $token, $clientId, $clientSecret, $userAgent, $options) use ($expectedOptions) {
            $this->assertEquals($expectedOptions, $options);

            return true;
        });

        $lwa = new Lwa(
            self::TEST_CLIENT_ID,
            self::TEST_CLIENT_SECRET,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $instanceOptions
        );

        $lwa->refreshToken(self::TEST_REFRESH_TOKEN, $methodOptions);
    }

    /**
     * @test
     */
    public function it_uses_empty_options_by_default(): void
    {
        $this->mockSpapiLwaStaticMethod('refreshToken', [], function ($uri, $token, $clientId, $clientSecret, $userAgent, $options) {
            $this->assertEquals([], $options);

            return true;
        });

        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);
        $lwa->refreshToken(self::TEST_REFRESH_TOKEN);
    }

    /**
     * @test
     */
    public function it_requires_string_refresh_token(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->refreshToken(null);
    }

    /**
     * @test
     */
    public function it_requires_string_scope(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->clientCredentials(null);
    }

    /**
     * @test
     */
    public function it_requires_array_options_in_constructor(): void
    {
        $this->expectException(TypeError::class);
        new Lwa(
            self::TEST_CLIENT_ID,
            self::TEST_CLIENT_SECRET,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            'not-an-array'
        );
    }

    /**
     * @test
     */
    public function it_requires_array_options_in_refresh_token(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->refreshToken(self::TEST_REFRESH_TOKEN, 'not-an-array');
    }

    /**
     * @test
     */
    public function it_requires_array_options_in_client_credentials(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->clientCredentials(self::TEST_SCOPE, 'not-an-array');
    }

    /**
     * Helper method to mock SpapiLwa static methods
     */
    private function mockSpapiLwaStaticMethod(string $method, array $return, callable $callback = null): void
    {
        $mock = Mockery::mock('alias:'.SpapiLwa::class);

        $expectation = $mock->shouldReceive($method)
            ->once()
            ->andReturn($return);

        if ($callback) {
            $expectation->withArgs($callback);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}