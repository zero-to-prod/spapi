<?php
/**
 * @noinspection PhpVariableIsUsedOnlyInClosureInspection
 * @noinspection PhpSameParameterValueInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpExpressionResultUnusedInspection
 * @noinspection PhpStrictTypeCheckingInspection
 */

declare(strict_types=1);

namespace Zerotoprod\Spapi\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use TypeError;
use Zerotoprod\Spapi\Tokens;
use Zerotoprod\SpapiTokens\SpapiTokens;

class TokensTest extends TestCase
{
    private const TEST_ACCESS_TOKEN = 'test-access-token';
    private const TEST_BASE_URI = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken';
    private const TEST_ORDER_ID = 'test-order-id';
    private const TEST_DATA_ELEMENTS = ['buyerInfo', 'shippingAddress'];
    private const TEST_DELEGATEE = 'test-delegatee';

    /** @test */
    public function it_creates_instance_with_minimal_parameters(): void
    {
        $tokens = new Tokens(self::TEST_ACCESS_TOKEN);

        $this->assertInstanceOf(Tokens::class, $tokens);
    }

    /** @test */
    public function it_gets_token_for_specific_order(): void
    {
        $expectedResponse = ['restrictedDataToken' => 'new-token'];
        $expectedPath = '/orders/v0/orders/'.self::TEST_ORDER_ID;

        $this->mockSpapiTokensStaticMethod('createRestrictedDataToken', $expectedResponse, function ($accessToken, $path) use ($expectedPath) {
            $this->assertEquals(self::TEST_ACCESS_TOKEN, $accessToken);
            $this->assertEquals($expectedPath, $path);

            return true;
        });

        $tokens = new Tokens(self::TEST_ACCESS_TOKEN);
        $response = $tokens->order(self::TEST_ORDER_ID);

        $this->assertEquals($expectedResponse, $response);
    }

    /** @test */
    public function it_gets_token_for_orders_endpoint(): void
    {
        $expectedResponse = ['restrictedDataToken' => 'new-token'];
        $expectedPath = '/orders/v0/orders';

        $this->mockSpapiTokensStaticMethod('createRestrictedDataToken', $expectedResponse, function ($accessToken, $path) use ($expectedPath) {
            $this->assertEquals(self::TEST_ACCESS_TOKEN, $accessToken);
            $this->assertEquals($expectedPath, $path);

            return true;
        });

        $tokens = new Tokens(self::TEST_ACCESS_TOKEN);
        $response = $tokens->orders();

        $this->assertEquals($expectedResponse, $response);
    }

    /** @test */
    public function it_passes_delegatee_correctly(): void
    {
        $this->mockSpapiTokensStaticMethod('createRestrictedDataToken', [], function ($accessToken, $path, $dataElements, $delegatee) {
            $this->assertEquals(self::TEST_DELEGATEE, $delegatee);

            return true;
        });

        $tokens = new Tokens(
            self::TEST_ACCESS_TOKEN,
            self::TEST_DELEGATEE
        );

        $tokens->orders();
    }

    /** @test */
    public function it_requires_string_access_token(): void
    {
        $this->expectException(TypeError::class);
        new Tokens(null);
    }

    /** @test */
    public function it_requires_array_options(): void
    {
        $this->expectException(TypeError::class);
        new Tokens(
            self::TEST_ACCESS_TOKEN,
            [],
            null,
            self::TEST_BASE_URI,
            null,
            'not-an-array'
        );
    }

    /** @test */
    public function it_requires_string_order_id(): void
    {
        $tokens = new Tokens(self::TEST_ACCESS_TOKEN);

        $this->expectException(TypeError::class);
        $tokens->order(null);
    }

    private function mockSpapiTokensStaticMethod(string $method, array $return, callable $callback = null): void
    {
        $mock = Mockery::mock('alias:'.SpapiTokens::class);

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