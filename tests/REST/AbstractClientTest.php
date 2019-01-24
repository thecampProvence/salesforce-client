<?php

namespace Tests\WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use WakeOnWeb\SalesforceClient\REST\Client as SUT;
use WakeOnWeb\SalesforceClient\REST\Gateway;
use WakeOnWeb\SalesforceClient\REST\GrantType\StrategyInterface;

abstract class AbstractClientTest extends TestCase
{
    protected $modelClassName;

    protected function createSUT(Request $requestExpected = null, Response $httpClientResponse)
    {
        $gateway = $this->createMock(Gateway::class);
        $gateway->expects($this->once())
            ->method('getServiceDataUrl')
            ->willReturn('https://domain.tld');

        $grantTypeStrategy = $this->createMock(StrategyInterface::class);
        $httpClient = $this->createMock(\GuzzleHttp\Client::class);

        if ($requestExpected) {
            $httpClient->expects($this->once())
                ->method('send')
                ->with($requestExpected)
                ->willReturn($httpClientResponse);
        } else {
            $httpClient->expects($this->once())
                ->method('send')
                ->willReturn($httpClientResponse);
        }

        $grantTypeStrategy
            ->expects($this->once())
            ->method('buildAccessToken')
            ->willReturn('access_token');

        if (false === is_null($this->modelClassName)) {
            $normalizerName = 'WakeOnWeb\SalesforceClient\Normalizer\\'.$this->modelClassName.'Normalizer';
            $serializer     = new Serializer([new $normalizerName()], [new JsonEncoder()]);
        } else {
            $serializer = new Serializer([], [new JsonEncoder()]);
        }

        return new SUT($serializer, $gateway, $grantTypeStrategy, $httpClient);
    }
}
