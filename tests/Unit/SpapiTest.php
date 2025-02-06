<?php
/**
 * @noinspection PhpStrictTypeCheckingInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use TypeError;
use Zerotoprod\Spapi\Spapi;

class SpapiTest extends TestCase
{
    private const DEFAULT_BASE_URI = 'https://sellingpartnerapi-na.amazon.com';
    private const TEST_ACCESS_TOKEN = 'test-access-token';
    private const TEST_BASE_URI = 'https://custom-api.amazon.com';
    private const TEST_USER_AGENT = 'CustomUserAgent/1.0';

    /** @test */
    public function it_creates_instance_with_minimal_parameters(): void
    {
        $spapi = new Spapi(self::TEST_ACCESS_TOKEN);

        $this->assertInstanceOf(Spapi::class, $spapi);
    }

    /** @test */
    public function it_creates_instance_with_all_parameters(): void
    {
        $options = ['timeout' => 30];
        $spapi = new Spapi(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $options
        );

        $this->assertInstanceOf(Spapi::class, $spapi);
    }

    /** @test */
    public function it_accepts_null_user_agent(): void
    {
        $spapi = new Spapi(
            self::TEST_ACCESS_TOKEN,
            self::DEFAULT_BASE_URI,
            null
        );

        $this->assertInstanceOf(Spapi::class, $spapi);
    }

    /** @test */
    public function it_accepts_empty_options_array(): void
    {
        $spapi = new Spapi(
            self::TEST_ACCESS_TOKEN,
            self::DEFAULT_BASE_URI,
            null,
            []
        );

        $this->assertInstanceOf(Spapi::class, $spapi);
    }

    /** @test */
    public function it_requires_access_token(): void
    {
        $this->expectException(TypeError::class);
        new Spapi(null);
    }

    /** @test */
    public function it_requires_string_access_token(): void
    {
        $this->expectException(TypeError::class);
        new Spapi(123);
    }

    /** @test */
    public function it_requires_string_base_uri(): void
    {
        $this->expectException(TypeError::class);
        new Spapi(self::TEST_ACCESS_TOKEN, 123);
    }

    /** @test */
    public function it_requires_array_options(): void
    {
        $this->expectException(TypeError::class);
        new Spapi(self::TEST_ACCESS_TOKEN, self::DEFAULT_BASE_URI, null, 'not-an-array');
    }
}