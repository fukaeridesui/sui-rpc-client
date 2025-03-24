<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Options for retrieving coins of a specific type
 * Used by suix_getCoins API method
 */
class GetCoinsOptions extends PaginationOptions
{
    /**
     * Coin type (e.g. "0x2::sui::SUI")
     * Required parameter
     */
    public ?string $coinType = null;
}
