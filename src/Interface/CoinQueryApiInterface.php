<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;

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
}
