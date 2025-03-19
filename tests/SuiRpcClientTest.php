<?php

namespace Fukaeridesui\SuiRpcClient\Tests;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\SuiRpcClient;

class SuiRpcClientTest extends TestCase
{
    public function testGetObjectReturnsArray()
    {
        $client = new SuiRpcClient('https://fullnode.mainnet.sui.io:443');

        $objectId = '0x27197dc8f23d96af32267b0a1d43e6b07b350c474a8a32d5af12580366ad6f80';
        $result = $client->getObject($objectId);
        var_dump($result);
        $this->assertIsArray($result);
    }
}
