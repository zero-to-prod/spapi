<?php
/**
 * @noinspection PhpExpressionResultUnusedInspection
 * @noinspection PhpStrictTypeCheckingInspection
 * @noinspection PhpParamsInspection
 */

declare(strict_types=1);

namespace Tests\Unit\Orders;

use Mockery;
use PHPUnit\Framework\TestCase;
use TypeError;
use Zerotoprod\Spapi\Orders;
use Zerotoprod\SpapiOrders\SpapiOrders;

class OrdersTest extends TestCase
{
    private const TEST_ACCESS_TOKEN = 'test-access-token';
    private const TEST_BASE_URI = 'https://sellingpartnerapi-na.amazon.com';
    private const TEST_USER_AGENT = 'CustomUserAgent/1.0';
    private const TEST_ORDER_ID = 'test-order-id';
    private const TEST_MARKETPLACE_IDS = ['ATVPDKIKX0DER'];

    /** @test */
    public function it_creates_instance_with_minimal_parameters(): void
    {
        $orders = new Orders(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI
        );

        $this->assertInstanceOf(Orders::class, $orders);
    }

    /** @test */
    public function it_creates_instance_with_all_parameters(): void
    {
        $options = ['timeout' => 30];
        $orders = new Orders(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI,
            self::TEST_USER_AGENT,
            $options
        );

        $this->assertInstanceOf(Orders::class, $orders);
    }

    /** @test */
    public function it_gets_order_with_minimal_parameters(): void
    {
        $expectedResponse = ['orderId' => self::TEST_ORDER_ID];

        $this->mockSpapiOrdersStaticMethod('getOrder', $expectedResponse);

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $response = $orders->getOrder(self::TEST_ORDER_ID);

        $this->assertEquals($expectedResponse, $response);
    }

    /** @test */
    public function it_gets_order_with_options(): void
    {
        $instanceOptions = ['timeout' => 30];
        $methodOptions = ['retry' => true];
        $expectedOptions = array_merge($instanceOptions, $methodOptions);

        $this->mockSpapiOrdersStaticMethod('getOrder', [], function ($uri, $token, $orderId, $userAgent, $options) use ($expectedOptions) {
            $this->assertEquals($expectedOptions, $options);

            return true;
        });

        $orders = new Orders(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI,
            null,
            $instanceOptions
        );

        $orders->getOrder(self::TEST_ORDER_ID, $methodOptions);
    }

    /** @test */
    public function it_gets_orders_with_minimal_parameters(): void
    {
        $expectedResponse = ['orders' => []];

        $this->mockSpapiOrdersStaticMethod('getOrders', $expectedResponse);

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $response = $orders->getOrders(self::TEST_MARKETPLACE_IDS);

        $this->assertEquals($expectedResponse, $response);
    }

    /** @test */
    /** @test */
    public function it_gets_orders_with_all_parameters(): void
    {
        $params = [
            'CreatedAfter' => '2023-01-01',
            'CreatedBefore' => '2023-12-31',
            'LastUpdatedAfter' => '2023-06-01',
            'LastUpdatedBefore' => '2023-06-30',
            'OrderStatuses' => ['Shipped'],
            'FulfillmentChannels' => ['MFN'],
            'PaymentMethods' => ['COD'],
            'BuyerEmail' => 'test@example.com',
            'SellerOrderId' => 'seller-123',
            'MaxResultsPerPage' => 100,
            'EasyShipShipmentStatuses' => ['ReadyForPickup'],
            'ElectronicInvoiceStatuses' => ['NotRequired'],
            'NextToken' => 'next-token',
            'AmazonOrderIds' => ['order-123'],
            'ActualFulfillmentSupplySourceId' => 'source-123',
            'IsIspu' => true,
            'StoreChainStoreId' => 'store-123',
            'EarliestDeliveryDateBefore' => '2023-12-31',
            'EarliestDeliveryDateAfter' => '2023-01-01',
            'LatestDeliveryDateBefore' => '2023-12-31',
            'LatestDeliveryDateAfter' => '2023-01-01'
        ];

        $this->mockSpapiOrdersStaticMethod('getOrders', [], function (...$args) use ($params) {
            // Base parameters check
            $this->assertEquals(self::TEST_BASE_URI, $args[0], 'Base URI mismatch');
            $this->assertEquals(self::TEST_ACCESS_TOKEN, $args[1], 'Access token mismatch');
            $this->assertEquals(self::TEST_MARKETPLACE_IDS, $args[2], 'Marketplace IDs mismatch');

            // Date parameters
            $this->assertEquals($params['CreatedAfter'], $args[3], 'CreatedAfter mismatch');
            $this->assertEquals($params['CreatedBefore'], $args[4], 'CreatedBefore mismatch');
            $this->assertEquals($params['LastUpdatedAfter'], $args[5], 'LastUpdatedAfter mismatch');
            $this->assertEquals($params['LastUpdatedBefore'], $args[6], 'LastUpdatedBefore mismatch');

            // Order status and fulfillment parameters
            $this->assertEquals($params['OrderStatuses'], $args[7], 'OrderStatuses mismatch');
            $this->assertEquals($params['FulfillmentChannels'], $args[8], 'FulfillmentChannels mismatch');
            $this->assertEquals($params['PaymentMethods'], $args[9], 'PaymentMethods mismatch');

            // Buyer and seller information
            $this->assertEquals($params['BuyerEmail'], $args[10], 'BuyerEmail mismatch');
            $this->assertEquals($params['SellerOrderId'], $args[11], 'SellerOrderId mismatch');

            // Pagination and results
            $this->assertEquals($params['MaxResultsPerPage'], $args[12], 'MaxResultsPerPage mismatch');

            // Shipment and invoice statuses
            $this->assertEquals($params['EasyShipShipmentStatuses'], $args[13], 'EasyShipShipmentStatuses mismatch');
            $this->assertEquals($params['ElectronicInvoiceStatuses'], $args[14], 'ElectronicInvoiceStatuses mismatch');

            // Token and order IDs
            $this->assertEquals($params['NextToken'], $args[15], 'NextToken mismatch');
            $this->assertEquals($params['AmazonOrderIds'], $args[16], 'AmazonOrderIds mismatch');

            // Fulfillment and store information
            $this->assertEquals($params['ActualFulfillmentSupplySourceId'], $args[17], 'ActualFulfillmentSupplySourceId mismatch');
            $this->assertEquals($params['IsIspu'], $args[18], 'IsIspu mismatch');
            $this->assertEquals($params['StoreChainStoreId'], $args[19], 'StoreChainStoreId mismatch');

            // Delivery date parameters
            $this->assertEquals($params['EarliestDeliveryDateBefore'], $args[20], 'EarliestDeliveryDateBefore mismatch');
            $this->assertEquals($params['EarliestDeliveryDateAfter'], $args[21], 'EarliestDeliveryDateAfter mismatch');
            $this->assertEquals($params['LatestDeliveryDateBefore'], $args[22], 'LatestDeliveryDateBefore mismatch');
            $this->assertEquals($params['LatestDeliveryDateAfter'], $args[23], 'LatestDeliveryDateAfter mismatch');

            // User agent check (second to last parameter)
            $this->assertNull($args[24], 'User agent should be null');

            // Options check (last parameter)
            $this->assertEquals([], $args[25], 'Options should be empty array');

            return true;
        });

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $orders->getOrders(
            self::TEST_MARKETPLACE_IDS,
            $params['CreatedAfter'],
            $params['CreatedBefore'],
            $params['LastUpdatedAfter'],
            $params['LastUpdatedBefore'],
            $params['OrderStatuses'],
            $params['FulfillmentChannels'],
            $params['PaymentMethods'],
            $params['BuyerEmail'],
            $params['SellerOrderId'],
            $params['MaxResultsPerPage'],
            $params['EasyShipShipmentStatuses'],
            $params['ElectronicInvoiceStatuses'],
            $params['NextToken'],
            $params['AmazonOrderIds'],
            $params['ActualFulfillmentSupplySourceId'],
            $params['IsIspu'],
            $params['StoreChainStoreId'],
            $params['EarliestDeliveryDateBefore'],
            $params['EarliestDeliveryDateAfter'],
            $params['LatestDeliveryDateBefore'],
            $params['LatestDeliveryDateAfter']
        );
    }

    /** @test */
    public function it_gets_orders_with_options(): void
    {
        $instanceOptions = ['timeout' => 30];
        $methodOptions = ['retry' => true];
        $expectedOptions = array_merge($instanceOptions, $methodOptions);

        $this->mockSpapiOrdersStaticMethod('getOrders', [], function (...$args) use ($expectedOptions) {
            // Options should be the last parameter
            $this->assertEquals($expectedOptions, end($args));

            return true;
        });

        $orders = new Orders(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI,
            null,
            $instanceOptions
        );

        $orders->getOrders(self::TEST_MARKETPLACE_IDS, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $methodOptions);
    }

    /** @test */
    public function it_requires_marketplace_ids(): void
    {
        $this->expectException(TypeError::class);

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $orders->getOrders(null);
    }

    /** @test */
    public function it_requires_array_marketplace_ids(): void
    {
        $this->expectException(TypeError::class);

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $orders->getOrders('not-an-array');
    }

    /** @test */
    public function it_requires_string_order_id(): void
    {
        $this->expectException(TypeError::class);

        $orders = new Orders(self::TEST_ACCESS_TOKEN, self::TEST_BASE_URI);
        $orders->getOrder(null);
    }

    /** @test */
    public function it_requires_array_options(): void
    {
        $this->expectException(TypeError::class);

        new Orders(
            self::TEST_ACCESS_TOKEN,
            self::TEST_BASE_URI,
            null,
            'not-an-array'
        );
    }

    private function mockSpapiOrdersStaticMethod(string $method, array $return, callable $callback = null): void
    {
        $mock = Mockery::mock('alias:'.SpapiOrders::class);

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