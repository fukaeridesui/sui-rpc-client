<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

$client = new SuiRpcClient();

$objectIds = [
    '0x0000000000000000000000000000000000000000000000000000000000000005',
    '0x0000000000000000000000000000000000000000000000000000000000000006',
];

if ($argc > 1) {
    $objectIds = array_slice($argv, 1);
}

$options = new GetObjectOptions([
    'showType' => true,
    'showContent' => true,
    'showOwner' => true,
    'showDisplay' => true
]);

try {
    $response = $client->getMultipleObjects($objectIds, $options);

    echo "=== multiple objects ===\n";
    echo "number of objects: " . $response->count() . "\n\n";

    foreach ($response->getObjects() as $index => $object) {
        echo "object #" . ($index + 1) . ":\n";
        echo "  ID: " . $object->getObjectId() . "\n";
        echo "  owner: " . $object->getOwner() . "\n";
        echo "  type: " . $object->getType() . "\n";

        if ($object->getDigest()) {
            echo "  digest: " . $object->getDigest() . "\n";
        }

        if ($object->getVersion()) {
            echo "  version: " . $object->getVersion() . "\n";
        }

        echo "\n";
    }
    echo "=== object details (JSON) ===\n";
    echo json_encode($response->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    if (!empty($objectIds)) {
        $searchId = $objectIds[0];
        echo "\n=== search by object ID ===\n";
        echo "search ID: " . $searchId . "\n";

        $foundObject = $response->findById($searchId);
        if ($foundObject) {
            echo "found! type: " . $foundObject->getType() . "\n";
        } else {
            echo "object not found.\n";
        }
    }
} catch (\Exception $e) {
    echo "error: " . $e->getMessage() . "\n";

    if ($e instanceof \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException) {
        if ($e->getRpcError()) {
            echo "\nRPC error details:\n";
            print_r($e->getRpcError());
        }
    }
}
