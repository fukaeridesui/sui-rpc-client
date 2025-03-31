<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;

// RPC URLを設定
$rpcUrl = 'https://fullnode.mainnet.sui.io:443';

// クライアントを初期化
$client = new SuiRpcClient($rpcUrl);

// チェックポイントのシーケンス番号を指定
$sequenceNumber = "1000";

try {
    // チェックポイントを取得
    $response = $client->getCheckpoint($sequenceNumber);

    // 結果を表示
    echo "チェックポイント情報:\n";
    echo "シーケンス番号: " . $response->getSequenceNumber() . "\n";
    echo "エポック: " . $response->getEpoch() . "\n";
    echo "タイムスタンプ: " . date('Y-m-d H:i:s', $response->getTimestamp() / 1000) . "\n";
    echo "ダイジェスト: " . $response->getDigest() . "\n";
    echo "前のダイジェスト: " . ($response->getPreviousDigest() ?? 'なし') . "\n";
    echo "ネットワーク総トランザクション数: " . $response->getNetworkTotalTransactions() . "\n";
    echo "トランザクションダイジェスト数: " . count($response->getTransactionDigests()) . "\n";
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage() . "\n";
} 