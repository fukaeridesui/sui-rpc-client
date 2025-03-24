<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetBalanceOptions;

// Get address from command line arguments (or use default if not specified)
$owner = $argv[1] ?? '0x5094652429957619e6efa376c66c6d24f0b2306c3e34d7f335f749765b17d435';

// Get optional coin type from command line arguments
$coinType = isset($argv[2]) ? $argv[2] : null;

// Initialize SuiRpcClient
$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";
echo "Getting balance for address: $owner\n";

if ($coinType) {
    echo "Coin Type: $coinType\n";
} else {
    echo "Coin Type: SUI (default)\n";
}
echo "\n";

try {
    // Create options with coin type if specified
    $options = null;
    if ($coinType) {
        $options = new GetBalanceOptions(['coinType' => $coinType]);
    }

    // Get balance for the specified coin type (or SUI by default)
    $balance = $client->getBalance($owner, $options);

    // Display balance information
    echo "=== Balance Information ===\n";
    echo "Coin Type: " . $balance->getCoinType() . "\n";
    echo "Coin Object Count: " . $balance->getCoinObjectCount() . "\n";
    echo "Total Balance: " . $balance->getTotalBalance() . "\n";

    // Convert balance to human-readable format if it's SUI
    if (strpos($balance->getCoinType(), "::sui::SUI") !== false) {
        $humanReadable = bcdiv($balance->getTotalBalance(), "1000000000", 9);
        echo "Human-readable Balance: $humanReadable SUI\n";
    }

    // Display locked balance info if present
    $lockedBalance = $balance->getLockedBalance();
    if (!empty($lockedBalance)) {
        echo "\n=== Locked Balance Information ===\n";
        echo json_encode($lockedBalance, JSON_PRETTY_PRINT) . "\n";
    }

    // Display full response as array
    echo "\n=== Raw Balance Data ===\n";
    echo json_encode($balance->toArray(), JSON_PRETTY_PRINT) . "\n";
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
