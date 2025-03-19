<?php

namespace Fukaeridesui\SuiRpcClient;

use GuzzleHttp\Client;

class SuiRpcClient
{
    private Client $httpClient;
    private string $rpcUrl;

    public function __construct(string $rpcUrl)
    {
        $this->rpcUrl = $rpcUrl;
        $this->httpClient = new Client(['base_uri' => $rpcUrl]);
    }

    public function getObject(string $objectId): array
    {
        $response = $this->httpClient->post('', [
            'json' => [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'sui_getObject',
                'params' => [$objectId]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['result'] ?? [];
    }
}
