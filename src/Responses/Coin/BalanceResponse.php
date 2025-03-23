<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Coin;

/**
 * Coin balance response
 */
class BalanceResponse
{
    private string $coinType;
    private int $coinObjectCount;
    private string $totalBalance;
    private array $lockedBalance;

    /**
     * @param array $data API response data
     */
    public function __construct(array $data)
    {
        $this->coinType = $data['coinType'] ?? '';
        $this->coinObjectCount = (int)($data['coinObjectCount'] ?? 0);
        $this->totalBalance = $data['totalBalance'] ?? '0';
        $this->lockedBalance = $data['lockedBalance'] ?? [];
    }

    /**
     * Get coin type
     * 
     * @return string Coin type
     */
    public function getCoinType(): string
    {
        return $this->coinType;
    }

    /**
     * Get coin object count
     * 
     * @return int Coin object count
     */
    public function getCoinObjectCount(): int
    {
        return $this->coinObjectCount;
    }

    /**
     * Get total balance
     * 
     * @return string Total balance
     */
    public function getTotalBalance(): string
    {
        return $this->totalBalance;
    }

    /**
     * Get locked balance
     * 
     * @return array Locked balance
     */
    public function getLockedBalance(): array
    {
        return $this->lockedBalance;
    }

    /**
     * Get data as array
     * 
     * @return array Data array
     */
    public function toArray(): array
    {
        return [
            'coinType' => $this->coinType,
            'coinObjectCount' => $this->coinObjectCount,
            'totalBalance' => $this->totalBalance,
            'lockedBalance' => $this->lockedBalance
        ];
    }
}
