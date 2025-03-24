<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Options for retrieving the balance of a specific coin type owned by an address
 */
class GetBalanceOptions extends BaseOptions
{
    /**
     * Coin type (e.g. "0x2::sui::SUI")
     * If not specified, defaults to SUI token
     */
    public ?string $coinType = null;
}
