<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

$client = new SuiRpcClient();

echo "Using RPC URL: " . $client->getRpcUrl() . "\n\n";

// Sui coin object ID
$objectId = '0x0000000000000000000000000000000000000000000000000000000000000005';

$options = new GetObjectOptions([
    'showType' => true,
    'showContent' => true,
    'showOwner' => true,
    'showDisplay' => true,
    'showPreviousTransaction' => true
]);

try {
    $response = $client->getObject($objectId, $options);

    echo "=== Sui Object Information ===\n";
    echo "Object ID: " . $response->getObjectId() . "\n";
    echo "Owner: " . $response->getOwner() . "\n";
    echo "Type: " . $response->getType() . "\n";

    if ($response->getDigest()) {
        echo "Digest: " . $response->getDigest() . "\n";
    }

    if ($response->getVersion()) {
        echo "Version: " . $response->getVersion() . "\n";
    }

    echo "\nContent:\n";
    print_r($response->getContent());

    if ($response->getDisplay()) {
        echo "\nDisplay:\n";
        print_r($response->getDisplay());
    }

    if ($response->getPreviousTransaction()) {
        echo "\nPrevious Transaction: " . $response->getPreviousTransaction() . "\n";
    }

    echo "\nComplete data as array:\n";
    print_r($response->toArray());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
