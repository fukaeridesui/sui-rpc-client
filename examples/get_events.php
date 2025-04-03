<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// Set RPC URL
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// Initialize client
$client = new SuiRpcClient($rpcUrl);

// Specify transaction hash
// NOTE: Replace with an actual transaction ID
$transactionDigest = '';

try {
    // Get events for the transaction
    $events = $client->getEvents($transactionDigest);
    
    // Display results
    echo "Events for transaction {$transactionDigest}:\n";
    $eventList = $events->getData();
    
    if (count($eventList) > 0) {
        foreach ($eventList as $index => $event) {
            echo "\nEvent " . ($index + 1) . ":\n";
            echo "  Transaction digest: " . $event->getTxDigest() . "\n";
            echo "  Event sequence: " . $event->getEventSeq() . "\n";
            echo "  Full ID: " . $event->getId() . "\n";
            echo "  Type: " . $event->getType() . "\n";
            echo "  Package ID: " . $event->getPackageId() . "\n";
            echo "  Module: " . $event->getTransactionModule() . "\n";
            echo "  Sender: " . $event->getSender() . "\n";
            
            // Only display timestamp if available
            $timestamp = $event->getTimestampMs();
            if (!empty($timestamp)) {
                echo "  Timestamp: " . date('Y-m-d H:i:s', intval($timestamp) / 1000) . "\n";
            }
            
            // Display BCS information if available
            if (!empty($event->getBcs())) {
                echo "  BCS: " . $event->getBcs() . "\n";
            }
            
            if (!empty($event->getBcsEncoding())) {
                echo "  BCS encoding: " . $event->getBcsEncoding() . "\n";
            }
            
            // Display parsed JSON data if available
            $parsedJson = $event->getParsedJson();
            if (!empty($parsedJson)) {
                echo "  Parsed JSON:\n";
                print_r($parsedJson);
            }
        }
    } else {
        echo "No events found.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    
    // Set PHP error handling (for debugging)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} 