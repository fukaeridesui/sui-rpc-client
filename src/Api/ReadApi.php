<?php

namespace Fukaeridesui\SuiRpcClient\Api;

use Fukaeridesui\SuiRpcClient\Interface\ReadApiInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\Read\GetObjectResponse;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;
use Fukaeridesui\SuiRpcClient\Responses\Read\ChainIdentifierResponse;

class ReadApi implements ReadApiInterface
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient HTTP client
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface
    {
        $options ??= new GetObjectOptions();

        $result = $this->httpClient->request('sui_getObject', [
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

        $result = $this->httpClient->request('sui_multiGetObjects', [
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
    public function getChainIdentifier(): ChainIdentifierResponse
    {
        $result = $this->httpClient->request('sui_getChainIdentifier', []);
        return new ChainIdentifierResponse($result);
    }
}
