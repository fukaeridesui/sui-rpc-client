<?php

namespace Fukaeridesui\SuiRpcClient\Contracts;

use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;

interface ReadApiInterface
{
    /**
     * Get object by object ID
     *
     * @param string $objectId Object ID
     * @param GetObjectOptions|null $options Get options
     * @return ObjectResponseInterface Response object
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface;

    /**
     * Get multiple objects
     *
     * @param string[] $objectIds Array of object IDs
     * @param GetObjectOptions|null $options Get options
     * @return MultipleObjectsResponse Multiple objects response
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getMultipleObjects(array $objectIds, ?GetObjectOptions $options = null): MultipleObjectsResponse;
}
