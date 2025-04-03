<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetCheckpointsOptions;

// Set RPC URL
// Using testnet
$rpcUrl = 'https://fullnode.testnet.sui.io:443';

// Initialize client
$client = new SuiRpcClient($rpcUrl);

// Set basic options only
$options = new GetCheckpointsOptions();
$options->setLimit(5)
        ->setDescendingOrder(true); // Get newest checkpoints first

try {
    echo "Retrieving checkpoints...\n";
    // Get list of checkpoints
    $response = $client->getCheckpoints($options);

    // Display results
    echo "Checkpoint list:\n";
    echo "Total count: " . count($response->getData()) . "\n";
    echo "Has next page: " . ($response->hasNextPage() ? 'yes' : 'no') . "\n";
    echo "Next cursor: " . ($response->getNextCursor() ?? 'none') . "\n\n";

    foreach ($response->getData() as $index => $checkpoint) {
        echo "Checkpoint " . ($index + 1) . ":\n";
        echo "  Sequence number: " . $checkpoint->getSequenceNumber() . "\n";
        echo "  Epoch: " . $checkpoint->getEpoch() . "\n";
        echo "  Timestamp: " . date('Y-m-d H:i:s', $checkpoint->getTimestamp() / 1000) . "\n";
        echo "  Digest: " . $checkpoint->getDigest() . "\n";
        echo "\n";
    }

    // If there's a next page, display the cursor
    if ($response->hasNextPage() && $response->getNextCursor() !== null) {
        echo "Next cursor value: " . $response->getNextCursor() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Add debug information
    echo "Detailed information:\n";
    echo "Exception class: " . get_class($e) . "\n";
    if (method_exists($e, 'getTraceAsString')) {
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
} 