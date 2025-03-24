<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Options for retrieving all coins owned by an address
 */
class GetAllCoinsOptions extends BaseOptions
{
    /**
     * Optional paging cursor
     */
    public ?string $cursor = null;

    /**
     * Maximum number of items per page
     */
    public ?int $limit = null;
}
