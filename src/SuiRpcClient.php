<?php

namespace Fukaeridesui\SuiRpcClient;

use Fukaeridesui\SuiRpcClient\Api\CoinQueryApi;
use Fukaeridesui\SuiRpcClient\Api\ReadApi;
use Fukaeridesui\SuiRpcClient\Interface\CoinQueryApiInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Interface\ReadApiInterface;
use Fukaeridesui\SuiRpcClient\Http\GuzzleHttpClient;
use Fukaeridesui\SuiRpcClient\Http\Psr18HttpClient;
use Fukaeridesui\SuiRpcClient\Options\GetAllCoinsOptions;
use Fukaeridesui\SuiRpcClient\Options\GetBalanceOptions;
use Fukaeridesui\SuiRpcClient\Options\GetCoinMetadataOptions;
use Fukaeridesui\SuiRpcClient\Options\GetCoinsOptions;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\CoinMetadataResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\GetAllCoinsResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\TotalSupplyResponse;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

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
     * Create a client with a PSR-18 HTTP client
     * 
     * @param string $rpcUrl RPC URL
     * @param ClientInterface $httpClient PSR-18 HTTP client
     * @param RequestFactoryInterface $requestFactory PSR-17 request factory
     * @param StreamFactoryInterface $streamFactory PSR-17 stream factory
     * @return self
     */
    public static function createWithPsr18Client(
        string $rpcUrl,
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ): self {
        $client = new Psr18HttpClient($rpcUrl, $httpClient, $requestFactory, $streamFactory);
        return new self($rpcUrl, $client);
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
     * Direct access to getAllCoins method (for convenience)
     * 
     * @param string $owner Owner's Sui address
     * @param GetAllCoinsOptions|null $options Pagination options
     * @return GetAllCoinsResponse Response containing coin objects and pagination info
     */
    public function getAllCoins(string $owner, ?GetAllCoinsOptions $options = null): GetAllCoinsResponse
    {
        return $this->coinQueryApi->getAllCoins($owner, $options);
    }

    /**
     * Direct access to getCoins method (for convenience)
     * 
     * @param string $owner Owner's Sui address
     * @param GetCoinsOptions $options Options with coin type and pagination
     * @return GetAllCoinsResponse Response containing coin objects and pagination info
     */
    public function getCoins(string $owner, GetCoinsOptions $options): GetAllCoinsResponse
    {
        return $this->coinQueryApi->getCoins($owner, $options);
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

    /**
     * Direct access to getBalance method (for convenience)
     * 
     * @param string $owner Sui address of the owner
     * @param GetBalanceOptions|null $options Get options
     * @return BalanceResponse Balance response
     */
    public function getBalance(string $owner, ?GetBalanceOptions $options = null): BalanceResponse
    {
        return $this->coinQueryApi->getBalance($owner, $options);
    }

    /**
     * Direct access to getCoinMetadata method (for convenience)
     * 
     * @param GetCoinMetadataOptions $options Options with coin type
     * @return CoinMetadataResponse Coin metadata response
     */
    public function getCoinMetadata(GetCoinMetadataOptions $options): CoinMetadataResponse
    {
        return $this->coinQueryApi->getCoinMetadata($options);
    }

    /**
     * Direct access to getTotalSupply method (for convenience)
     * 
     * @param string $coinType Coin type
     * @return TotalSupplyResponse Total supply response
     */
    public function getTotalSupply(string $coinType): TotalSupplyResponse
    {
        return $this->coinQueryApi->getTotalSupply($coinType);
    }
}
