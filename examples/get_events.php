<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// RPC URLを設定
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// クライアントを初期化
$client = new SuiRpcClient($rpcUrl);

// トランザクションハッシュを指定
// NOTE: 実際のトランザクションIDに置き換えてください
$transactionDigest = 'H6nfBu9YAHCshnMj69vzBw9fW2Y9gWZSxuQW8j1fZiGu';

try {
    // トランザクションのイベントを取得
    $events = $client->getEvents($transactionDigest);
    
    // 結果を表示
    echo "トランザクション {$transactionDigest} のイベント:\n";
    $eventList = $events->getData();
    
    if (count($eventList) > 0) {
        foreach ($eventList as $index => $event) {
            echo "\nイベント " . ($index + 1) . ":\n";
            echo "  ID: " . $event->getId() . "\n";
            echo "  タイプ: " . $event->getType() . "\n";
            echo "  パッケージID: " . $event->getPackageId() . "\n";
            echo "  モジュール: " . $event->getTransactionModule() . "\n";
            echo "  送信者: " . $event->getSender() . "\n";
            echo "  タイムスタンプ: " . date('Y-m-d H:i:s', intval($event->getTimestampMs()) / 1000) . "\n";
            
            // パースされたJSONデータがあれば表示
            $parsedJson = $event->getParsedJson();
            if (!empty($parsedJson)) {
                echo "  パースされたJSON:\n";
                print_r($parsedJson);
            }
        }
    } else {
        echo "イベントが見つかりませんでした。\n";
    }
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage() . "\n";
} 