<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Initialize the client
$client = new SuiRpcClient();

// Get total supply for SUI coin
$coinType = '0x2::sui::SUI';
$response = $client->getTotalSupply($coinType);

// Display the result
echo "Total Supply for {$coinType}: " . $response->getValue() . "\n";
