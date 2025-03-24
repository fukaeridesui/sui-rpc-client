<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Common pagination options
 * Used by multiple API methods like suix_getAllCoins, suix_getCoins, etc.
 */
class PaginationOptions extends BaseOptions
{
    /**
     * Cursor for getting the next page
     * Can be obtained from previous response
     */
    public ?string $cursor = null;

    /**
     * Maximum number of items per page
     */
    public ?int $limit = null;
}
