<?php

namespace Fukaeridesui\SuiRpcClient\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;
use Psr\Http\Client\ClientInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    private Client $client;
    private string $rpcUrl;

    /**
     * @param string $rpcUrl RPC URL
     */
    public function __construct(string $rpcUrl)
    {
        $this->rpcUrl = $rpcUrl;
        $this->client = new Client([
            'base_uri' => $rpcUrl,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method, array $params = []): mixed
    {
        try {
            $response = $this->client->post('', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => $method,
                    'params' => $params
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['error'])) {
                throw new SuiRpcException($result['error'], $result['error']['message'] ?? null);
            }

            return $result['result'];
        } catch (GuzzleException $e) {
            throw new SuiRpcException(null, $e->getMessage());
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
        return $this->client;
    }
}
