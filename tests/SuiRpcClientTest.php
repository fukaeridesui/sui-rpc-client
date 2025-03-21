<?php

namespace Fukaeridesui\SuiRpcClient\Tests;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;

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

        $mockHttpClient = $this->createMock(Client::class);
        $mockHttpClient->method('post')->willReturn($mockResponse);

        $rpcClient = new SuiRpcClient('https://mock.node', $mockHttpClient);

        $options = new GetObjectOptions();
        $response = $rpcClient->getObject('0xMOCKOBJECTID', $options);

        $this->assertInstanceOf(ObjectResponseInterface::class, $response);
        $this->assertEquals('0xMOCKOBJECTID', $response->getObjectId());
        $this->assertEquals('0xMOCKOWNER', $response->getOwner());
        $this->assertEquals('0x2::coin::Coin<0x2::sui::SUI>', $response->getType());
        $this->assertIsArray($response->getContent());
    }
}
