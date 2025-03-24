<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Options for retrieving metadata for a specific coin type
 */
class GetCoinMetadataOptions extends BaseOptions
{
    /**
     * Coin type (e.g. "0x2::sui::SUI")
     * Required for this method
     */
    public ?string $coinType = null;
}
