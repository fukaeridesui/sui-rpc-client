<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Coin;

/**
 * Response for the suix_getCoinMetadata API call
 * Contains metadata information for a coin type
 */
class CoinMetadataResponse
{
    /**
     * The number of decimal places the coin uses
     */
    private int $decimals;

    /**
     * Name of the token
     */
    private string $name;

    /**
     * Symbol of the token
     */
    private string $symbol;

    /**
     * Description of the token
     */
    private string $description;

    /**
     * URL for the token logo (can be null)
     */
    private ?string $iconUrl;

    /**
     * Object ID for the CoinMetadata object (can be null)
     */
    private ?string $id;

    /**
     * @param array $data API response data
     */
    public function __construct(array $data)
    {
        $this->decimals = (int)($data['decimals'] ?? 0);
        $this->name = $data['name'] ?? '';
        $this->symbol = $data['symbol'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->iconUrl = $data['iconUrl'] ?? null;
        $this->id = $data['id'] ?? null;
    }

    /**
     * Get the number of decimal places the coin uses
     * 
     * @return int Number of decimal places
     */
    public function getDecimals(): int
    {
        return $this->decimals;
    }

    /**
     * Get the name of the token
     * 
     * @return string Token name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the symbol of the token
     * 
     * @return string Token symbol
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * Get the description of the token
     * 
     * @return string Token description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the URL for the token logo
     * 
     * @return string|null Token logo URL or null if not available
     */
    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    /**
     * Get the object ID for the CoinMetadata object
     * 
     * @return string|null Object ID or null if not available
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Get data as array
     * 
     * @return array Data array
     */
    public function toArray(): array
    {
        return [
            'decimals' => $this->decimals,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description,
            'iconUrl' => $this->iconUrl,
            'id' => $this->id
        ];
    }
}
