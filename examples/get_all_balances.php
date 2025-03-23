<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Get address from command line arguments (or use default if not specified)
$owner = $argv[1] ?? '0x5094652429957619e6efa376c66c6d24f0b2306c3e34d7f335f749765b17d435';

// Initialize SuiRpcClient
$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";
echo "Getting all coin balances for address: $owner\n\n";

try {
    // Call getAllBalances method
    $balances = $client->getAllBalances($owner);

    // Display results
    echo "Found " . count($balances) . " coin types\n\n";

    // Variable for calculating total balance
    $totalSuiBalance = "0";

    // Display balance for each coin
    foreach ($balances as $index => $balance) {
        echo "Coin #" . ($index + 1) . ":\n";
        echo "  Type: " . $balance->getCoinType() . "\n";
        echo "  Object Count: " . $balance->getCoinObjectCount() . "\n";
        echo "  Total Balance: " . $balance->getTotalBalance() . "\n";

        // Record SUI coin balance
        if (str_contains($balance->getCoinType(), "0x2::sui::SUI")) {
            $totalSuiBalance = $balance->getTotalBalance();
        }

        // Display locked balance info if exists
        if (!empty($balance->getLockedBalance())) {
            echo "  Locked Balance: " . json_encode($balance->getLockedBalance()) . "\n";
        }

        echo "\n";
    }

    // Display total SUI amount in human-readable format (SUI has 9 decimal places)
    if ($totalSuiBalance !== "0") {
        $humanReadable = bcdiv($totalSuiBalance, "1000000000", 9);
        echo "Total SUI balance: $humanReadable SUI\n";
    }

    // Display the first coin in array format as an example of detailed information
    if (count($balances) > 0) {
        echo "\nFirst balance as array:\n";
        echo json_encode($balances[0]->toArray(), JSON_PRETTY_PRINT) . "\n";
    }
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
