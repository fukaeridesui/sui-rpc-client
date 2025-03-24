<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Http\Psr18HttpClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

/**
 * Example: How to use a custom PSR-18 HTTP client
 * 
 * This example demonstrates two approaches:
 * 1. Using the factory method with a PSR-18 client
 * 2. Creating a custom adapter and passing it to the constructor
 */

// Get object ID from command line arguments or use default
$objectId = $argv[1] ?? '0x0000000000000000000000000000000000000000000000000000000000000005';

echo "Using object ID: " . $objectId . "\n\n";

/**
 * Approach 1: Using the factory method
 * 
 * Note: To run this example, you need to install these packages:
 * - guzzlehttp/guzzle (for GuzzleHttp\Client)
 * - guzzlehttp/psr7 (for GuzzleHttp\Psr7\HttpFactory)
 * 
 * Or replace with any other PSR-18 client and PSR-17 factories.
 */
echo "=== Approach 1: Using the factory method ===\n";

// Comment out this section if you don't have guzzle installed
if (class_exists('GuzzleHttp\Client') && class_exists('GuzzleHttp\Psr7\HttpFactory')) {
    // Create the PSR-18 client and PSR-17 factories
    $httpClient = new GuzzleHttp\Client();
    $httpFactory = new GuzzleHttp\Psr7\HttpFactory();

    // Create the SuiRpcClient with the PSR-18 client
    $client = SuiRpcClient::createWithPsr18Client(
        'https://fullnode.mainnet.sui.io:443',
        $httpClient,
        $httpFactory,
        $httpFactory  // Same factory for streams
    );

    echo "Client created using GuzzleHttp client via the factory method\n";
    echo "RPC URL: " . $client->getRpcUrl() . "\n";

    // Use the client as usual
    try {
        $response = $client->getObject($objectId, new GetObjectOptions([
            'showType' => true,
            'showContent' => true,
        ]));

        echo "Object type: " . $response->getType() . "\n";
        echo "Object owner: " . $response->getOwner() . "\n\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "GuzzleHttp client not available. Install it with:\n";
    echo "composer require guzzlehttp/guzzle guzzlehttp/psr7\n\n";
}

/**
 * Approach 2: Creating a custom PSR-18 implementation
 * 
 * This example demonstrates how to create a custom implementation
 * of the HttpClientInterface that delegates to any PSR-18 client.
 */
echo "=== Approach 2: Creating your own adapter manually ===\n";

class MyAdapter extends Psr18HttpClient
{
    // You can add custom behavior here if needed

    public function __construct($rpcUrl, $client, $requestFactory, $streamFactory)
    {
        parent::__construct($rpcUrl, $client, $requestFactory, $streamFactory);
        echo "Created custom adapter with URL: " . $rpcUrl . "\n";
    }
}

// Comment out this section if you don't have guzzle installed
if (class_exists('GuzzleHttp\Client') && class_exists('GuzzleHttp\Psr7\HttpFactory')) {
    // Create the PSR-18 client and PSR-17 factories
    $httpClient = new GuzzleHttp\Client();
    $httpFactory = new GuzzleHttp\Psr7\HttpFactory();

    // Create a custom adapter
    $adapter = new MyAdapter(
        'https://fullnode.mainnet.sui.io:443',
        $httpClient,
        $httpFactory,
        $httpFactory
    );

    // Create the SuiRpcClient with the custom adapter
    $client = new SuiRpcClient('https://fullnode.mainnet.sui.io:443', $adapter);

    echo "Client created using custom adapter\n";

    // Use the client as usual
    try {
        $response = $client->getObject($objectId, new GetObjectOptions([
            'showType' => true,
            'showContent' => true,
        ]));

        echo "Object type: " . $response->getType() . "\n";
        echo "Object owner: " . $response->getOwner() . "\n\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "GuzzleHttp client not available. Install it with:\n";
    echo "composer require guzzlehttp/guzzle guzzlehttp/psr7\n\n";
}

echo "=== Usage with other HTTP clients ===\n";
echo "You can use any PSR-18 compliant HTTP client by following the patterns above.\n";
echo "Examples include:\n";
echo "- Symfony HTTP Client: symfony/http-client + nyholm/psr7\n";
echo "- PHP-HTTP Adapters: php-http/guzzle7-adapter, php-http/curl-client, etc.\n";
echo "- HTTPlug clients: guzzlehttp/guzzle, kriswallsmith/buzz, etc.\n";
echo "- Laminas HTTP client: laminas/laminas-http with an adapter\n\n";
echo "Each client may require different PSR-17 factories. Check their documentation.\n";
