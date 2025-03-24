<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetAllCoinsOptions;

// Get address from command line arguments (or use default if not specified)
$owner = $argv[1] ?? '0x5094652429957619e6efa376c66c6d24f0b2306c3e34d7f335f749765b17d435';

// Optional limit parameter 
$limit = isset($argv[2]) ? (int)$argv[2] : null;

// Initialize SuiRpcClient
$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";
echo "Getting all coins for address: $owner\n";
if ($limit) {
    echo "Using limit: $limit\n";
}
echo "\n";

try {
    // Create options with limit if specified
    $options = null;
    if ($limit) {
        $options = new GetAllCoinsOptions(['limit' => $limit]);
    }

    // Initial fetch
    $allCoins = $client->getAllCoins($owner, $options);

    // Display initial page
    displayCoinsPage($allCoins, 1);

    // Handle pagination if user wants to see more
    $pageNum = 2;
    while ($allCoins->hasNextPage() && askUserToContinue()) {
        $nextCursor = $allCoins->getNextCursor();
        echo "Fetching page $pageNum with cursor: $nextCursor\n\n";

        $options = new GetAllCoinsOptions([
            'cursor' => $nextCursor,
            'limit' => $limit
        ]);

        $allCoins = $client->getAllCoins($owner, $options);
        displayCoinsPage($allCoins, $pageNum);
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

    // Get all available coin types on this page
    $coinTypes = $coinsResponse->getCoinTypes();

    // Display coins by type
    foreach ($coinTypes as $type) {
        $totalBalance = $coinsResponse->getTotalBalanceForType($type);

        // Convert SUI balance to human-readable format if applicable
        $humanReadableBalance = $totalBalance;
        if (strpos($type, "::sui::SUI") !== false) {
            $humanReadableBalance = bcdiv($totalBalance, "1000000000", 9) . " SUI";
        }

        echo "Coin Type: $type\n";
        echo "Total Balance: $humanReadableBalance\n";

        // Display individual coins of this type
        $typeCoins = array_filter($coinsResponse->getData(), function ($coin) use ($type) {
            return $coin->getCoinType() === $type;
        });

        echo "Individual coins:\n";
        foreach ($typeCoins as $index => $coin) {
            echo "  #" . ($index + 1) . ": " . $coin->getCoinObjectId() . " (Balance: " . $coin->getBalance() . ")\n";
        }
        echo "\n";
    }

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
