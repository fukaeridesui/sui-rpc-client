<?php

namespace Fukaeridesui\SuiRpcClient\Contracts;

use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;

interface CoinQueryApiInterface
{
    /**
     * Get all coin type balances owned by the address
     *
     * @param string $owner Owner's Sui address
     * @return array<BalanceResponse> Array of balance information
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getAllBalances(string $owner): array;
}
