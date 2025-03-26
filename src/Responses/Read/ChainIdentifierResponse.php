<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Chain identifier response
 */
class ChainIdentifierResponse
{
    private string $chainId;

    /**
     * @param string|array $data API response data
     */
    public function __construct($data)
    {
        $this->chainId = is_array($data) ? $data['chainId'] : $data;
    }

    /**
     * Get chain identifier
     * 
     * @return string Chain identifier
     */
    public function getChainId(): string
    {
        return $this->chainId;
    }

    /**
     * Convert to array
     * 
     * @return array Array representation of the response
     */
    public function toArray(): array
    {
        return [
            'chainId' => $this->chainId
        ];
    }
}
