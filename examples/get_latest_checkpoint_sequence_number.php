<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Set RPC URL
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// Initialize client
$client = new SuiRpcClient($rpcUrl);

try {
    // Get the latest checkpoint sequence number
    $response = $client->getLatestCheckpointSequenceNumber();
    
    // Display results
    echo "Latest checkpoint sequence number: " . $response->getSequenceNumber() . "\n";
    
    // Let's also fetch the checkpoint details using this sequence number
    echo "\nFetching details for this checkpoint...\n";
    $checkpoint = $client->getCheckpoint($response->getSequenceNumber());
    
    // Display checkpoint information
    echo "Checkpoint information:\n";
    echo "Sequence number: " . $checkpoint->getSequenceNumber() . "\n";
    echo "Epoch: " . $checkpoint->getEpoch() . "\n";
    $num = $checkpoint->getTimestamp();
    echo "Timestamp: " . date('Y-m-d H:i:s', intdiv($num, 1000)) . "\n";
    echo "Digest: " . $checkpoint->getDigest() . "\n";
    echo "Network total transactions: " . $checkpoint->getNetworkTotalTransactions() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Add debug information
    echo "Detailed information:\n";
    echo "Exception class: " . get_class($e) . "\n";
    if (method_exists($e, 'getTraceAsString')) {
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
} 