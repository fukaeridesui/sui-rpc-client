<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

if ($argc < 2) {
    echo "how to use: php explore_object.php <object ID>\n";
    echo "e.g. php explore_object.php 0x5f8331a48a5afd38be7f70a43d3c898f3b58a828c859f79ecf87c44b2856ac94\n";
    exit(1);
}

$objectId = $argv[1];

$network = $argv[2] ?? 'mainnet';

switch ($network) {
    case 'testnet':
        $rpcUrl = 'https://fullnode.testnet.sui.io:443';
        break;
    case 'devnet':
        $rpcUrl = 'https://fullnode.devnet.sui.io:443';
        break;
    case 'mainnet':
    default:
        $rpcUrl = null;
}

$client = $rpcUrl ? new SuiRpcClient($rpcUrl) : new SuiRpcClient();

echo "Using network: " . ($network) . " (" . $client->getRpcUrl() . ")\n\n";

$options = new GetObjectOptions([
    'showType' => true,
    'showContent' => true,
    'showOwner' => true,
    'showDisplay' => true,
    'showPreviousTransaction' => true,
    'showBcs' => true,
    'showStorageRebate' => true
]);

try {
    $response = $client->getObject($objectId, $options);

    echo "=== Sui Object Explorer ===\n";
    echo "Object ID: " . $response->getObjectId() . "\n";
    echo "Owner: " . $response->getOwner() . "\n";
    echo "Type: " . $response->getType() . "\n";

    if ($response->getDigest()) {
        echo "Digest: " . $response->getDigest() . "\n";
    }

    if ($response->getVersion()) {
        echo "Version: " . $response->getVersion() . "\n";
    }

    if ($response->getStorageRebate()) {
        echo "Storage Rebate: " . $response->getStorageRebate() . "\n";
    }

    if ($response->getPreviousTransaction()) {
        echo "Previous Transaction: " . $response->getPreviousTransaction() . "\n";
    }

    echo "\nContent (Formatted JSON):\n";
    echo json_encode($response->getContent(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    if ($response->getDisplay()) {
        echo "\nDisplay Data (Formatted JSON):\n";
        echo json_encode($response->getDisplay(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }

    echo "\nRaw Response Data:\n";
    echo json_encode($response->toArray(), JSON_PRETTY_PRINT) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";

    if ($e instanceof \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException) {
        if ($e->getRpcError()) {
            echo "\nRPC Error Details:\n";
            print_r($e->getRpcError());
        }
    }
}
