<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Coin;

/**
 * Response for the suix_getAllCoins API call
 * Contains a collection of coin objects and pagination information
 */
class GetAllCoinsResponse
{
    /**
     * @var CoinObjectResponse[] Array of coin objects
     */
    private array $data;

    /**
     * Next cursor for pagination (null if no more pages)
     */
    private ?string $nextCursor;

    /**
     * Whether there are more results available
     */
    private bool $hasNextPage;

    /**
     * @param array $response API response
     */
    public function __construct(array $response)
    {
        $this->data = [];

        foreach ($response['data'] ?? [] as $coinData) {
            $this->data[] = new CoinObjectResponse($coinData);
        }

        $this->nextCursor = $response['nextCursor'] ?? null;
        $this->hasNextPage = !empty($this->nextCursor);
    }

    /**
     * Get all coin objects
     *
     * @return CoinObjectResponse[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the next cursor for pagination
     *
     * @return string|null Next cursor or null if no more pages
     */
    public function getNextCursor(): ?string
    {
        return $this->nextCursor;
    }

    /**
     * Check if there are more pages available
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->hasNextPage;
    }

    /**
     * Get number of coin objects in the current page
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Get coin object at specified index
     *
     * @param int $index Index
     * @return CoinObjectResponse|null Coin object or null if index out of range
     */
    public function getCoinAt(int $index): ?CoinObjectResponse
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Get all coin types present in the collection
     *
     * @return array Array of unique coin types
     */
    public function getCoinTypes(): array
    {
        $types = [];
        foreach ($this->data as $coin) {
            $type = $coin->getCoinType();
            if (!in_array($type, $types)) {
                $types[] = $type;
            }
        }
        return $types;
    }

    /**
     * Calculate total balance across all coins of a specific type
     *
     * @param string $coinType Coin type to calculate total for
     * @return string Total balance as string (to handle large numbers)
     */
    public function getTotalBalanceForType(string $coinType): string
    {
        $total = '0';
        foreach ($this->data as $coin) {
            if ($coin->getCoinType() === $coinType) {
                $total = bcadd($total, $coin->getBalance(), 0);
            }
        }
        return $total;
    }

    /**
     * Convert the response to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $coinsArray = [];
        foreach ($this->data as $coin) {
            $coinsArray[] = $coin->toArray();
        }

        return [
            'data' => $coinsArray,
            'nextCursor' => $this->nextCursor,
            'hasNextPage' => $this->hasNextPage
        ];
    }
}
