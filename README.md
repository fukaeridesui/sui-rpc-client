# Sui RPC Client

A PHP RPC client for querying the Sui blockchain.

## Installation (not available yet!!!)

```bash
composer require fukaeridesui/sui-rpc-client
```

## Basic Usage

```php
// Initialize the client
$client = new \Fukaeridesui\SuiRpcClient\SuiRpcClient();

// Direct method access
$object = $client->getObject('0x123...');
$objects = $client->getMultipleObjects(['0x123...', '0x456...']);
$balances = $client->getAllBalances('0x789...');

// Or access through specific API categories
$object = $client->read()->getObject('0x123...');
$balances = $client->coin()->getAllBalances('0x789...');
```

## Example Scripts

Check the `examples` directory for sample scripts:

- `get_object.php`: Retrieves a predefined SUI object
- `explore_object.php`: Allows you to specify any object ID as a command-line argument
- `get_multiple_objects.php`: Demonstrates fetching multiple objects at once
- `get_all_balances.php`: Shows how to retrieve all coin balances for an address

Run examples:

```bash
# Get a predefined object
php examples/get_object.php

# Explore a specific object
php examples/explore_object.php 0x0000000000000000000000000000000000000000000000000000000000000005

# Explore a specific object with network
php examples/explore_object.php 0x0000000000000000000000000000000000000000000000000000000000000005 testnet

# Explore multiple objects 
php examples/get_multiple_objects.php
# Explore multiple objects by ids
php examples/get_multiple_objects.php 0x123... 0x456...

# Get all balances for an address
php examples/get_all_balances.php
# Get all balances for a specific address
php examples/get_all_balances.php 0x789...
```

## Available Networks

The client supports the following Sui networks by default:

- Mainnet: `https://fullnode.mainnet.sui.io:443` (default)
- Testnet: `https://fullnode.testnet.sui.io:443`
- Devnet: `https://fullnode.devnet.sui.io:443`

## Architecture

The client uses a facade pattern to provide a simple interface to various API categories:

- **Read API**: For retrieving objects and blockchain data
- **Coin Query API**: For querying coin balances and information
