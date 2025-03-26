<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Initialize the client
$client = new SuiRpcClient();

// Get chain identifier
$response = $client->getChainIdentifier();

// Display the result
echo "Chain Identifier: " . $response->getChainId() . "\n";
