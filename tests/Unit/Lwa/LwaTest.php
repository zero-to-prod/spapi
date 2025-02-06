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

    /** @test */
    public function it_creates_instance_with_minimal_parameters(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->assertInstanceOf(Lwa::class, $lwa);
    }

    /** @test */
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

    /** @test */
    public function it_requires_string_refresh_token(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->refreshToken(null);
    }

    /** @test */
    public function it_requires_string_scope(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->clientCredentials(null);
    }

    /** @test */
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

    /** @test */
    public function it_requires_array_options_in_refresh_token(): void
    {
        $lwa = new Lwa(self::TEST_CLIENT_ID, self::TEST_CLIENT_SECRET);

        $this->expectException(TypeError::class);
        $lwa->refreshToken(self::TEST_REFRESH_TOKEN, 'not-an-array');
    }

    /** @test */
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