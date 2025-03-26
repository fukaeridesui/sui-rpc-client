<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

use Fukaeridesui\SuiRpcClient\Options\GetAllCoinsOptions;
use Fukaeridesui\SuiRpcClient\Options\GetBalanceOptions;
use Fukaeridesui\SuiRpcClient\Options\GetCoinMetadataOptions;
use Fukaeridesui\SuiRpcClient\Options\GetCoinsOptions;
use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\CoinMetadataResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\GetAllCoinsResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\TotalSupplyResponse;

interface CoinQueryApiInterface
{
    /**
     * Get all coin type balances owned by the address
     *
     * @param string $owner Sui address of the owner
     * @return array<BalanceResponse> Array of balance information
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getAllBalances(string $owner): array;

    /**
     * Get all coin objects owned by an address with pagination support
     *
     * @param string $owner Owner's Sui address
     * @param GetAllCoinsOptions|null $options Pagination options
     * @return GetAllCoinsResponse Response containing coin objects and pagination info
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getAllCoins(string $owner, ?GetAllCoinsOptions $options = null): GetAllCoinsResponse;

    /**
     * Get coins of a specific type owned by an address with pagination support
     *
     * @param string $owner Owner's Sui address
     * @param GetCoinsOptions $options Options with coin type (required) and pagination
     * @return GetAllCoinsResponse Response containing coin objects and pagination info
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getCoins(string $owner, GetCoinsOptions $options): GetAllCoinsResponse;

    /**
     * Get balance for a specific coin type owned by an address
     *
     * @param string $owner Owner's Sui address
     * @param GetBalanceOptions|null $options Options with coin type (defaults to SUI)
     * @return BalanceResponse Balance information for the specified coin type
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getBalance(string $owner, ?GetBalanceOptions $options = null): BalanceResponse;

    /**
     * Get metadata for a specific coin type
     *
     * @param GetCoinMetadataOptions $options Options with coin type (required)
     * @return CoinMetadataResponse Metadata for the specified coin type
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getCoinMetadata(GetCoinMetadataOptions $options): CoinMetadataResponse;

    /**
     * Get total supply of a coin type
     *
     * @param string $coinType Coin type
     * @return TotalSupplyResponse Total supply response
     */
    public function getTotalSupply(string $coinType): TotalSupplyResponse;
}
