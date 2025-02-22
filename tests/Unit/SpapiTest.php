<?php
/**
 * @noinspection PhpStrictTypeCheckingInspection
 * @noinspection PhpParamsInspection
 * @noinspection PhpExpressionResultUnusedInspection
 */

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Zerotoprod\Spapi\Spapi;
use Zerotoprod\Spapi\Support\Testing\SpapiFake;
use Zerotoprod\SpapiLwa\SpapiLwa;
use Zerotoprod\SpapiLwa\Support\Testing\SpapiLwaFake;
use Zerotoprod\SpapiLwa\Support\Testing\SpapiLwaResponseFactory;
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersResponseFactory;
use Zerotoprod\SpapiRdt\SpapiRdt;
use Zerotoprod\SpapiRdt\Support\Testing\SpapiRdtFake;
use Zerotoprod\SpapiRdt\Support\Testing\SpapiRdtResponseFactory;
use Zerotoprod\SpapiTokens\SpapiTokens;

class SpapiTest extends TestCase
{

    /**
     * @var array
     */
    private $rdt;

    protected function setup(): void
    {
        parent::setUp();
        SpapiLwaFake::fake(
            SpapiLwaResponseFactory::factory()
                ->asRefreshTokenResponse()
                ->make()
        );
        SpapiRdtFake::fake(
            SpapiRdtResponseFactory::factory()->make()
        );

        $access_token = SpapiLwa::from(
            'client_id',
            'client_secret'
        )->refreshToken('refresh_token');

        $this->rdt = SpapiRdt::from(
            SpapiTokens::from(
                $access_token['response']['access_token'],
                'app'
            )
        )
            ->orders()
            ->getOrder('114-1576437-0127407')['response']['restrictedDataToken'];
    }

    /** @test */
    public function fakes_response(): void
    {
        $AmazonOrderId = '114-1576437-0127407';
        SpapiFake::fake(
            SpapiOrdersResponseFactory::factory()
                ->set('response', ['payload' => ['AmazonOrderId' => $AmazonOrderId]])
                ->make()
        );
        $Spapi = Spapi::from($this->rdt);

        $Order = $Spapi
            ->orders()
            ->getOrder($AmazonOrderId);

        self::assertEquals(
            $AmazonOrderId,
            $Order['response']['payload']['AmazonOrderId']
        );
    }
}