<?php

namespace Fukaeridesui\SuiRpcClient;

use Fukaeridesui\SuiRpcClient\Api\CoinQueryApi;
use Fukaeridesui\SuiRpcClient\Api\ReadApi;
use Fukaeridesui\SuiRpcClient\Interface\CoinQueryApiInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Interface\ReadApiInterface;
use Fukaeridesui\SuiRpcClient\Http\GuzzleHttpClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;

/**
 * Sui RPC Client
 */
class SuiRpcClient
{
    private HttpClientInterface $httpClient;
    private ReadApiInterface $readApi;
    private CoinQueryApiInterface $coinQueryApi;

    /**
     * @param string $rpcUrl RPC URL
     * @param HttpClientInterface|null $httpClient HTTP client
     */
    public function __construct(
        string $rpcUrl = 'https://fullnode.mainnet.sui.io:443',
        ?HttpClientInterface $httpClient = null
    ) {
        $this->httpClient = $httpClient ?? new GuzzleHttpClient($rpcUrl);
        $this->readApi = new ReadApi($this->httpClient);
        $this->coinQueryApi = new CoinQueryApi($this->httpClient);
    }

    /**
     * Access to Read API
     * 
     * @return ReadApiInterface
     */
    public function read(): ReadApiInterface
    {
        return $this->readApi;
    }

    /**
     * Access to Coin Query API
     * 
     * @return CoinQueryApiInterface
     */
    public function coin(): CoinQueryApiInterface
    {
        return $this->coinQueryApi;
    }

    /**
     * Direct access to getObject method (for convenience)
     * 
     * @param string $objectId Object ID
     * @param GetObjectOptions|null $options Get options
     * @return ObjectResponseInterface Response object
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface
    {
        return $this->readApi->getObject($objectId, $options);
    }

    /**
     * Direct access to getMultipleObjects method (for convenience)
     * 
     * @param string[] $objectIds Array of object IDs
     * @param GetObjectOptions|null $options Get options
     * @return MultipleObjectsResponse Multiple objects response
     */
    public function getMultipleObjects(array $objectIds, ?GetObjectOptions $options = null): MultipleObjectsResponse
    {
        return $this->readApi->getMultipleObjects($objectIds, $options);
    }

    /**
     * Direct access to getAllBalances method (for convenience)
     * 
     * @param string $owner Sui address of the owner
     * @return array Array of balance information
     */
    public function getAllBalances(string $owner): array
    {
        return $this->coinQueryApi->getAllBalances($owner);
    }

    /**
     * Get RPC URL
     * 
     * @return string RPC URL
     */
    public function getRpcUrl(): string
    {
        return $this->httpClient->getRpcUrl();
    }

    /**
     * Get HTTP client
     * 
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }
}
