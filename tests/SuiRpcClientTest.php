<?php

namespace Fukaeridesui\SuiRpcClient\Tests;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;
use Fukaeridesui\SuiRpcClient\Http\Psr18HttpClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SuiRpcClientTest extends TestCase
{
    public function testGetObjectReturnsValidResponse()
    {
        $mockResult = [
            'jsonrpc' => '2.0',
            'result' => [
                'data' => [
                    'objectId' => '0xMOCKOBJECTID',
                    'owner' => ['AddressOwner' => '0xMOCKOWNER'],
                    'type' => '0x2::coin::Coin<0x2::sui::SUI>',
                    'content' => ['fields' => ['balance' => '1000000']],
                ]
            ],
            'id' => 1
        ];

        $jsonString = json_encode($mockResult);

        $stream = Utils::streamFor($jsonString);

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($stream);

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->method('request')->willReturn($mockResult['result']);
        $mockHttpClient->method('getRpcUrl')->willReturn('https://mock.node');

        $rpcClient = new SuiRpcClient('https://mock.node', $mockHttpClient);

        $options = new GetObjectOptions();
        $response = $rpcClient->getObject('0xMOCKOBJECTID', $options);

        $this->assertInstanceOf(ObjectResponseInterface::class, $response);
        $this->assertEquals('0xMOCKOBJECTID', $response->getObjectId());
        $this->assertEquals('0xMOCKOWNER', $response->getOwner());
        $this->assertEquals('0x2::coin::Coin<0x2::sui::SUI>', $response->getType());
        $this->assertIsArray($response->getContent());
    }

    public function testCreateWithDefaultConstructor()
    {
        $client = new SuiRpcClient();
        $httpClient = $client->getHttpClient();

        $this->assertInstanceOf(HttpClientInterface::class, $httpClient);
    }

    public function testCreateWithCustomHttpClient()
    {
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $client = new SuiRpcClient('https://example.com', $mockHttpClient);

        $this->assertSame($mockHttpClient, $client->getHttpClient());
    }

    public function testCreateWithPsr18Client()
    {
        $mockPsrClient = $this->createMock(ClientInterface::class);
        $mockRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $mockStreamFactory = $this->createMock(StreamFactoryInterface::class);

        $client = SuiRpcClient::createWithPsr18Client(
            'https://example.com',
            $mockPsrClient,
            $mockRequestFactory,
            $mockStreamFactory
        );

        $httpClient = $client->getHttpClient();

        $this->assertInstanceOf(Psr18HttpClient::class, $httpClient);
        $this->assertSame($mockPsrClient, $httpClient->getPsrClient());
        $this->assertEquals('https://example.com', $httpClient->getRpcUrl());
    }
}
