# Sui RPC Client

A PHP RPC client for querying the Sui blockchain.

## Installation (not available yet!!!)

```bash
composer require fukaeridesui/sui-rpc-client
```

## Example Scripts

Check the `examples` directory for sample scripts:

- `get_object.php`: Retrieves a predefined SUI object
- `explore_object.php`: Allows you to specify any object ID as a command-line argument
- `get_multiple_objects.php`: Demonstrates fetching multiple objects at once

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
```

## Available Networks

The client supports the following Sui networks by default:

- Mainnet: `https://fullnode.mainnet.sui.io:443` (default)
- Testnet: `https://fullnode.testnet.sui.io:443`
- Devnet: `https://fullnode.devnet.sui.io:443`
