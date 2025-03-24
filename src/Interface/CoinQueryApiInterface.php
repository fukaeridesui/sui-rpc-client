<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

use Fukaeridesui\SuiRpcClient\Options\GetAllCoinsOptions;
use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;
use Fukaeridesui\SuiRpcClient\Responses\Coin\GetAllCoinsResponse;

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
}
