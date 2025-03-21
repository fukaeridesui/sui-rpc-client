# Sui RPC Client

A PHP RPC client for querying the Sui blockchain.

## Installation

```bash
composer require fukaeridesui/sui-rpc-client
```

## Basic Usage

```php
<?php

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

// Initialize the client with the RPC endpoint URL
$client = new SuiRpcClient('https://fullnode.mainnet.sui.io:443');

// Get an object by its ID
$objectId = '0x5f8331a48a5afd38be7f70a43d3c898f3b58a828c859f79ecf87c44b2856ac94';
$options = new GetObjectOptions([
    'showType' => true,
    'showContent' => true,
    'showOwner' => true
]);

try {
    $response = $client->getObject($objectId, $options);
    
    // Access object properties
    echo "Object ID: " . $response->getObjectId() . "\n";
    echo "Owner: " . $response->getOwner() . "\n";
    echo "Type: " . $response->getType() . "\n";
    
    // Get the object content
    $content = $response->getContent();
    
    // Convert to array
    $data = $response->toArray();
    
} catch (\Fukaeridesui\SuiRpcClient\Exception\SuiRpcException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Advanced Options

```php
// Set all available options
$options = new GetObjectOptions([
    'showType' => true,
    'showOwner' => true,
    'showPreviousTransaction' => true,
    'showDisplay' => true,
    'showContent' => true,
    'showBcs' => false,
    'showStorageRebate' => true
]);
```

## Example Scripts

Check the `examples` directory for sample scripts:

- `get_object.php`: Retrieves a predefined SUI object
- `explore_object.php`: Allows you to specify any object ID as a command-line argument

Run examples:

```bash
# Get a predefined object
php examples/get_object.php

# Explore a specific object
php examples/explore_object.php 0x5f8331a48a5afd38be7f70a43d3c898f3b58a828c859f79ecf87c44b2856ac94
```

## License

MIT