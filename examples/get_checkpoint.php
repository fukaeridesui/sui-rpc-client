<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Set RPC URL
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// Initialize client
$client = new SuiRpcClient($rpcUrl);

// Specify checkpoint sequence number
$sequenceNumber = "1000";

try {
    // Get checkpoint
    $response = $client->getCheckpoint($sequenceNumber);

    // Display results
    echo "Checkpoint information:\n";
    echo "Sequence number: " . $response->getSequenceNumber() . "\n";
    echo "Epoch: " . $response->getEpoch() . "\n";
    echo "Timestamp: " . date('Y-m-d H:i:s', $response->getTimestamp() / 1000) . "\n";
    echo "Digest: " . $response->getDigest() . "\n";
    echo "Previous digest: " . ($response->getPreviousDigest() ?? 'none') . "\n";
    echo "Network total transactions: " . $response->getNetworkTotalTransactions() . "\n";
    echo "Transaction digest count: " . count($response->getTransactionDigests()) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 