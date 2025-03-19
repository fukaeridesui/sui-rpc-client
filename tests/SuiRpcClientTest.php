<?php

namespace Fukaeridesui\SuiRpcClient\Tests;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\SuiRpcClient;

class SuiRpcClientTest extends TestCase
{
    public function testGetObjectReturnsArray()
    {
        $client = new SuiRpcClient('https://fullnode.testnet.sui.io:443');

        $objectId = '0x0000000000000000000000000000000000000000000000000000000000000000';
        $result = $client->getObject($objectId);

        $this->assertIsArray($result);
    }
}
