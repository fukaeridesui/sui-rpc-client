<?php

namespace Fukaeridesui\SuiRpcClient;

use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;

/**
 * Sui JSON-RPC Client Interface
 */
interface SuiRpcClientInterface
{
    /**
     * Get Object by Object ID
     *
     * @param string $objectId Object ID
     * @param GetObjectOptions|null $options Get Object Options
     * @return ObjectResponseInterface Response Object
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException RPC Error
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface;

    /**
     * Get RPC URL
     *
     * @return string RPC URL
     */
    public function getRpcUrl(): string;
}
