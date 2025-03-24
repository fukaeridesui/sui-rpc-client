<?php

namespace Fukaeridesui\SuiRpcClient\Http;

use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * PSR-18 compliant HTTP client implementation
 */
class Psr18HttpClient implements HttpClientInterface
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private string $rpcUrl;

    /**
     * @param string $rpcUrl RPC URL
     * @param ClientInterface $httpClient PSR-18 HTTP client
     * @param RequestFactoryInterface $requestFactory PSR-17 request factory
     * @param StreamFactoryInterface $streamFactory PSR-17 stream factory
     */
    public function __construct(
        string $rpcUrl,
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->rpcUrl = $rpcUrl;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, array $params = []): array
    {
        try {
            $jsonData = json_encode([
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => $method,
                'params' => $params
            ]);

            if ($jsonData === false) {
                throw new SuiRpcException(null, 'JSON encode error: ' . json_last_error_msg());
            }

            $request = $this->requestFactory->createRequest('POST', $this->rpcUrl)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->streamFactory->createStream($jsonData));

            $response = $this->httpClient->sendRequest($request);
            $contents = $response->getBody()->getContents();
            $body = json_decode($contents, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new SuiRpcException(
                    null,
                    'JSON decode error: ' . json_last_error_msg() . ', Response: ' . substr($contents, 0, 100)
                );
            }

            if (isset($body['error'])) {
                throw new SuiRpcException($body['error']);
            }

            if (!isset($body['result'])) {
                throw new SuiRpcException(null, 'Invalid RPC response: missing result field');
            }

            return $body['result'];
        } catch (ClientExceptionInterface $e) {
            throw new SuiRpcException(null, 'HTTP request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcUrl(): string
    {
        return $this->rpcUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getPsrClient(): ?ClientInterface
    {
        return $this->httpClient;
    }
}
