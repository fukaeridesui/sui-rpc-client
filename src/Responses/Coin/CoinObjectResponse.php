<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Coin;

/**
 * Represents a single coin object
 */
class CoinObjectResponse
{
    /**
     * Coin type (e.g. "0x2::sui::SUI")
     */
    private string $coinType;

    /**
     * Coin object ID
     */
    private string $coinObjectId;

    /**
     * Coin balance
     */
    private string $balance;

    /**
     * Coin object version
     */
    private string $version;

    /**
     * Coin object digest
     */
    private string $digest;

    /**
     * @param array $data Coin object data from API
     */
    public function __construct(array $data)
    {
        $this->coinType = $data['coinType'] ?? '';
        $this->coinObjectId = $data['coinObjectId'] ?? '';
        $this->balance = $data['balance'] ?? '0';
        $this->version = $data['version'] ?? '0';
        $this->digest = $data['digest'] ?? '';
    }

    /**
     * Get coin type (e.g. "0x2::sui::SUI")
     * 
     * @return string
     */
    public function getCoinType(): string
    {
        return $this->coinType;
    }

    /**
     * Get coin object ID
     * 
     * @return string
     */
    public function getCoinObjectId(): string
    {
        return $this->coinObjectId;
    }

    /**
     * Get coin balance
     * 
     * @return string
     */
    public function getBalance(): string
    {
        return $this->balance;
    }

    /**
     * Get coin object version
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get coin object digest
     * 
     * @return string
     */
    public function getDigest(): string
    {
        return $this->digest;
    }

    /**
     * Get coin data as array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'coinType' => $this->coinType,
            'coinObjectId' => $this->coinObjectId,
            'balance' => $this->balance,
            'version' => $this->version,
            'digest' => $this->digest,
        ];
    }
}
