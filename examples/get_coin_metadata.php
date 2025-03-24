<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetCoinMetadataOptions;

// Get coin type from command line arguments (or use default SUI if not specified)
$coinType = $argv[1] ?? '0x2::sui::SUI';

// Initialize SuiRpcClient
$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";
echo "Getting metadata for coin type: $coinType\n\n";

try {
    // Create options with the coin type
    $options = new GetCoinMetadataOptions(['coinType' => $coinType]);

    // Get coin metadata
    $metadata = $client->getCoinMetadata($options);

    // Display metadata information
    echo "=== Coin Metadata ===\n";
    echo "Name: " . $metadata->getName() . "\n";
    echo "Symbol: " . $metadata->getSymbol() . "\n";
    echo "Decimals: " . $metadata->getDecimals() . "\n";
    echo "Description: " . $metadata->getDescription() . "\n";

    if ($metadata->getIconUrl()) {
        echo "Icon URL: " . $metadata->getIconUrl() . "\n";
    } else {
        echo "Icon URL: None\n";
    }

    if ($metadata->getId()) {
        echo "Metadata Object ID: " . $metadata->getId() . "\n";
    } else {
        echo "Metadata Object ID: None\n";
    }

    // Convert a sample value to human-readable format using decimals
    $sampleValue = "1000000000";
    $divisor = bcpow("10", (string)$metadata->getDecimals(), 0);
    $humanReadable = bcdiv($sampleValue, $divisor, $metadata->getDecimals());

    echo "\nExample conversion:\n";
    echo "Raw value: $sampleValue\n";
    echo "Human-readable: $humanReadable " . $metadata->getSymbol() . "\n";

    // Display full response as array
    echo "\n=== Raw Metadata ===\n";
    echo json_encode($metadata->toArray(), JSON_PRETTY_PRINT) . "\n";
} catch (\Fukaeridesui\SuiRpcClient\Exception\SuiRpcException $e) {
    echo "SUI RPC Error: " . $e->getMessage() . "\n";
    if ($e->getCode()) {
        echo "Error code: " . $e->getCode() . "\n";
    }
    exit(1);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
