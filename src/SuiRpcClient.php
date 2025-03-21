<?php

namespace Fukaeridesui\SuiRpcClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\GetObjectResponse;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class SuiRpcClient implements SuiRpcClientInterface
{
    private Client $httpClient;
    private string $rpcUrl;

    /**
     * @param string $rpcUrl RPC URL (例: https://fullnode.mainnet.sui.io:443)
     * @param Client|null $httpClient 使用するHTTPクライアント
     * @param array $clientOptions Guzzleクライアントオプション
     */
    public function __construct(string $rpcUrl, ?Client $httpClient = null, array $clientOptions = [])
    {
        $this->rpcUrl = $rpcUrl;
        $defaultOptions = ['base_uri' => $rpcUrl];
        $options = array_merge($defaultOptions, $clientOptions);
        $this->httpClient = $httpClient ?? new Client($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface
    {
        $options ??= new GetObjectOptions();

        $result = $this->request('sui_getObject', [
            $objectId,
            $options->toArray()
        ]);

        return new GetObjectResponse($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcUrl(): string
    {
        return $this->rpcUrl;
    }

    /**
     * JSON-RPCリクエスト共通処理
     * 
     * @param string $method RPC メソッド名
     * @param array $params RPC パラメータ
     * @return array レスポンス結果
     * @throws SuiRpcException RPC エラー発生時
     */
    private function request(string $method, array $params = []): array
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
}
