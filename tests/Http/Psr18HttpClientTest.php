<?php

namespace Fukaeridesui\SuiRpcClient\Tests\Http;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\Http\Psr18HttpClient;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class Psr18HttpClientTest extends TestCase
{
    private $mockHttpClient;
    private $mockRequestFactory;
    private $mockStreamFactory;
    private $mockRequest;
    private $mockResponse;
    private $mockStream;

    protected function setUp(): void
    {
        $this->mockHttpClient = $this->createMock(ClientInterface::class);
        $this->mockRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->mockStreamFactory = $this->createMock(StreamFactoryInterface::class);
        $this->mockRequest = $this->createMock(RequestInterface::class);
        $this->mockResponse = $this->createMock(ResponseInterface::class);
        $this->mockStream = $this->createMock(StreamInterface::class);

        // Setup request creation expectations
        $this->mockRequestFactory->method('createRequest')
            ->willReturn($this->mockRequest);

        $this->mockRequest->method('withHeader')
            ->willReturn($this->mockRequest);

        $this->mockRequest->method('withBody')
            ->willReturn($this->mockRequest);

        $this->mockStreamFactory->method('createStream')
            ->willReturn($this->mockStream);
    }

    public function testRequestReturnsSuccessfulResponse()
    {
        // Setup response expectations
        $this->mockHttpClient->method('sendRequest')
            ->willReturn($this->mockResponse);

        $this->mockResponse->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->method('getContents')
            ->willReturn(json_encode([
                'jsonrpc' => '2.0',
                'id' => 1,
                'result' => ['objectId' => '0x123']
            ]));

        $client = new Psr18HttpClient(
            'https://example.com',
            $this->mockHttpClient,
            $this->mockRequestFactory,
            $this->mockStreamFactory
        );

        $result = $client->request('sui_getObject', ['0x123']);

        $this->assertEquals(['objectId' => '0x123'], $result);
    }

    public function testRequestHandlesErrorResponse()
    {
        // Setup response expectations with error
        $this->mockHttpClient->method('sendRequest')
            ->willReturn($this->mockResponse);

        $this->mockResponse->method('getBody')
            ->willReturn($this->mockStream);

        $this->mockStream->method('getContents')
            ->willReturn(json_encode([
                'jsonrpc' => '2.0',
                'id' => 1,
                'error' => ['code' => -32000, 'message' => 'Object not found']
            ]));

        $client = new Psr18HttpClient(
            'https://example.com',
            $this->mockHttpClient,
            $this->mockRequestFactory,
            $this->mockStreamFactory
        );

        $this->expectException(SuiRpcException::class);

        $client->request('sui_getObject', ['0x123']);
    }

    public function testGetRpcUrlReturnsCorrectUrl()
    {
        $url = 'https://example.com';

        $client = new Psr18HttpClient(
            $url,
            $this->mockHttpClient,
            $this->mockRequestFactory,
            $this->mockStreamFactory
        );

        $this->assertEquals($url, $client->getRpcUrl());
    }

    public function testGetPsrClientReturnsUnderlyingClient()
    {
        $client = new Psr18HttpClient(
            'https://example.com',
            $this->mockHttpClient,
            $this->mockRequestFactory,
            $this->mockStreamFactory
        );

        $this->assertSame($this->mockHttpClient, $client->getPsrClient());
    }
}
