<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetCoinsOptions;

// Get address from command line arguments (or use default if not specified)
$owner = $argv[1] ?? '0x5094652429957619e6efa376c66c6d24f0b2306c3e34d7f335f749765b17d435';

// Get coin type (required)
$coinType = $argv[2] ?? '0x2::sui::SUI';

// Optional limit parameter 
$limit = isset($argv[3]) ? (int)$argv[3] : null;

// Initialize SuiRpcClient
$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";
echo "Getting coins for address: $owner\n";
echo "Coin type: $coinType\n";
if ($limit) {
    echo "Using limit: $limit\n";
}
echo "\n";

try {
    // Create options with coin type and optional limit
    $options = new GetCoinsOptions([
        'coinType' => $coinType
    ]);

    if ($limit) {
        $options->limit = $limit;
    }

    // Initial fetch
    $coins = $client->getCoins($owner, $options);

    // Display initial page
    displayCoinsPage($coins, 1);

    // Handle pagination if user wants to see more
    $pageNum = 2;
    while ($coins->hasNextPage() && askUserToContinue()) {
        $nextCursor = $coins->getNextCursor();
        echo "Fetching page $pageNum with cursor: $nextCursor\n\n";

        $options = new GetCoinsOptions([
            'coinType' => $coinType,
            'cursor' => $nextCursor,
            'limit' => $limit
        ]);

        $coins = $client->getCoins($owner, $options);
        displayCoinsPage($coins, $pageNum);
        $pageNum++;
    }

    echo "End of coins listing.\n";
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

/**
 * Display a page of coins
 */
function displayCoinsPage($coinsResponse, $pageNum)
{
    echo "=== Page $pageNum ===\n";
    echo "Found " . $coinsResponse->count() . " coins on this page\n\n";

    // Calculate total balance for all coins on this page
    $totalBalance = '0';
    foreach ($coinsResponse->getData() as $coin) {
        $totalBalance = bcadd($totalBalance, $coin->getBalance(), 0);
    }

    // Display summary
    $coinType = $coinsResponse->count() > 0 ? $coinsResponse->getData()[0]->getCoinType() : "N/A";

    // Convert SUI balance to human-readable format if applicable
    $humanReadableBalance = $totalBalance;
    if (strpos($coinType, "::sui::SUI") !== false) {
        $humanReadableBalance = bcdiv($totalBalance, "1000000000", 9) . " SUI";
    }

    echo "Coin Type: $coinType\n";
    echo "Total Balance: $humanReadableBalance\n";

    // Display individual coins
    echo "Individual coins:\n";
    foreach ($coinsResponse->getData() as $index => $coin) {
        echo "  #" . ($index + 1) . ": " . $coin->getCoinObjectId() . " (Balance: " . $coin->getBalance() . ")\n";
    }
    echo "\n";

    // Information about next page
    if ($coinsResponse->hasNextPage()) {
        echo "Has more coins: Yes (Next cursor: " . $coinsResponse->getNextCursor() . ")\n\n";
    } else {
        echo "Has more coins: No\n\n";
    }
}

/**
 * Ask user if they want to continue to the next page
 */
function askUserToContinue()
{
    echo "Fetch next page? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    return trim($line) === 'y';
}
