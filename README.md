# Sui RPC Client

A PHP RPC client for querying the Sui blockchain.

## Installation (not available yet!!!)

```bash
composer require fukaeridesui/sui-rpc-client
```

## Basic Usage

```php
<?php

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

// Initialize the client with the default RPC endpoint URL (mainnet)
$client = new SuiRpcClient();

// Or specify a custom RPC endpoint
// $client = new SuiRpcClient('https://fullnode.testnet.sui.io:443');

// Get an object by its ID
$objectId = '0x0000000000000000000000000000000000000000000000000000000000000005';
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
php examples/explore_object.php 0x0000000000000000000000000000000000000000000000000000000000000005

# Explore a specific object with network
php examples/explore_object.php 0x0000000000000000000000000000000000000000000000000000000000000005 testnet
```

## Available Networks

The client supports the following Sui networks by default:

- Mainnet: `https://fullnode.mainnet.sui.io:443` (default)
- Testnet: `https://fullnode.testnet.sui.io:443` 
- Devnet: `https://fullnode.devnet.sui.io:443`
