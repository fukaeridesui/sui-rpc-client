<?php

// autoloaderの読み込み
require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

// ユーザー入力からオブジェクトIDを取得
if ($argc < 2) {
    echo "使用法: php explore_object.php <オブジェクトID>\n";
    echo "例: php explore_object.php 0x5f8331a48a5afd38be7f70a43d3c898f3b58a828c859f79ecf87c44b2856ac94\n";
    exit(1);
}

$objectId = $argv[1];

// Sui Mainnetの接続先URL
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// SUI RPC Clientの初期化
$client = new SuiRpcClient($rpcUrl);

// すべてのオプションを有効にする
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
    // オブジェクトの取得
    $response = $client->getObject($objectId, $options);

    // 結果の表示
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

    // 内容の詳細表示
    echo "\nContent (Formatted JSON):\n";
    echo json_encode($response->getContent(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    // 表示データがあれば表示
    if ($response->getDisplay()) {
        echo "\nDisplay Data (Formatted JSON):\n";
        echo json_encode($response->getDisplay(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }

    // 配列形式でのデータ表示
    echo "\nRaw Response Data:\n";
    echo json_encode($response->toArray(), JSON_PRETTY_PRINT) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";

    // SuiRpcExceptionの場合は詳細なエラー情報を表示
    if ($e instanceof \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException) {
        if ($e->getRpcError()) {
            echo "\nRPC Error Details:\n";
            print_r($e->getRpcError());
        }
    }
}
