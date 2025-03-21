<?php

// autoloaderの読み込み
require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;

// Sui Mainnetの接続先URL
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// SUI RPC Clientの初期化
$client = new SuiRpcClient($rpcUrl);

// Sui上の実在するオブジェクトID (SUI コイン)
$objectId = '0x0000000000000000000000000000000000000000000000000000000000000005';

// オプションの設定
$options = new GetObjectOptions([
    'showType' => true,
    'showContent' => true,
    'showOwner' => true,
    'showDisplay' => true,
    'showPreviousTransaction' => true
]);

try {
    // オブジェクトの取得
    $response = $client->getObject($objectId, $options);

    var_dump(gettype($response));

    // 結果の表示
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

    // 内容の表示（必要に応じて整形）
    echo "\nContent:\n";
    print_r($response->getContent());

    // 表示データがあれば表示
    if ($response->getDisplay()) {
        echo "\nDisplay:\n";
        print_r($response->getDisplay());
    }

    // 前回のトランザクションがあれば表示
    if ($response->getPreviousTransaction()) {
        echo "\nPrevious Transaction: " . $response->getPreviousTransaction() . "\n";
    }

    // 配列形式でのデータ表示
    echo "\nComplete data as array:\n";
    print_r($response->toArray());
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
