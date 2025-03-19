<?php

namespace Fukaeridesui\SuiRpcClient;

use GuzzleHttp\Client;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\GetObjectResponse;

class SuiRpcClient
{
    private Client $httpClient;
    private string $rpcUrl;

    public function __construct(string $rpcUrl)
    {
        $this->rpcUrl = $rpcUrl;
        $this->httpClient = new Client(['base_uri' => $rpcUrl]);
    }

    /**
     * Get Object by Object ID
     * @param string $objectId
     * @param GetObjectOptions|null $options
     * @return GetObjectResponse
     * @throws \Exception
     */
    public function getObject(string $objectId, GetObjectOptions $options = null): GetObjectResponse
    {
        $options ??= new GetObjectOptions();

        $result = $this->request('sui_getObject', [
            $objectId,
            $options->toArray()
        ]);

        // JSON-RPCレスポンス → DTOへ変換して返す
        return new GetObjectResponse($result);
    }

    /**
     * JSON-RPCリクエスト共通処理
     */
    private function request(string $method, array $params = [])
    {
        $response = $this->httpClient->post('', [
            'json' => [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => $method,
                'params' => $params
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (isset($body['error'])) {
            throw new \Exception("RPC Error: " . json_encode($body['error']));
        }

        return $body['result'] ?? null;
    }
}
