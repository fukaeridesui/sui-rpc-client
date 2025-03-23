<?php

namespace Fukaeridesui\SuiRpcClient\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class GuzzleHttpClient implements HttpClientInterface
{
    private Client $httpClient;
    private string $rpcUrl;

    /**
     * @param string $rpcUrl RPC URL
     * @param array $clientOptions Guzzle client options
     */
    public function __construct(
        string $rpcUrl = 'https://fullnode.mainnet.sui.io:443',
        array $clientOptions = []
    ) {
        $this->rpcUrl = $rpcUrl;
        $defaultOptions = ['base_uri' => $rpcUrl];
        $options = array_merge($defaultOptions, $clientOptions);
        $this->httpClient = new Client($options);
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, array $params = []): array
    {
        try {
            $response = $this->httpClient->post('', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => $method,
                    'params' => $params
                ]
            ]);

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
        } catch (GuzzleException $e) {
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
}
