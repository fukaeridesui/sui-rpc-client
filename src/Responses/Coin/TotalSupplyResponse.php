<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Coin;

/**
 * Total supply response
 */
class TotalSupplyResponse
{
    private string $value;

    /**
     * @param array $data API response data
     */
    public function __construct(array $data)
    {
        $this->value = $data['value'];
    }

    /**
     * Get total supply value
     * 
     * @return string Total supply value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Convert to array
     * 
     * @return array Array representation of the response
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value
        ];
    }
}
