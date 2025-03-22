<?php

namespace Fukaeridesui\SuiRpcClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\GetObjectResponse;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\MultipleObjectsResponse;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class SuiRpcClient implements SuiRpcClientInterface
{
    private Client $httpClient;
    private string $rpcUrl;

    /**
     * @param string $rpcUrl RPC URL (e.g. https://fullnode.mainnet.sui.io:443)
     * @param Client|null $httpClient HTTP Client
     * @param array $clientOptions Guzzle Client Options
     */
    public function __construct(string $rpcUrl = 'https://fullnode.mainnet.sui.io:443', ?Client $httpClient = null, array $clientOptions = [])
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
    public function getMultipleObjects(array $objectIds, ?GetObjectOptions $options = null): MultipleObjectsResponse
    {
        $options ??= new GetObjectOptions();

        if (empty($objectIds)) {
            return new MultipleObjectsResponse([]);
        }

        foreach ($objectIds as $objectId) {
            if (!is_string($objectId)) {
                throw new SuiRpcException(null, 'Invalid objectId: All elements must be strings');
            }
        }

        $result = $this->request('sui_multiGetObjects', [
            $objectIds,
            $options->toArray()
        ]);

        if (!is_array($result)) {
            throw new SuiRpcException(null, 'Invalid response: Expected array of objects');
        }

        $responses = [];
        foreach ($result as $objectData) {
            $responses[] = new GetObjectResponse($objectData);
        }

        return new MultipleObjectsResponse($responses);
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcUrl(): string
    {
        return $this->rpcUrl;
    }

    /**
     * Common JSON-RPC Request Processing
     * 
     * @param string $method RPC Method Name
     * @param array $params RPC Parameters
     * @return array Response Result
     * @throws SuiRpcException RPC Error Occurs
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
