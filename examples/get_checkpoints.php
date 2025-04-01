<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fukaeridesui\SuiRpcClient\SuiRpcClient;
use Fukaeridesui\SuiRpcClient\Options\GetCheckpointsOptions;

// RPC URLを設定
// テストネットを使用
$rpcUrl = 'https://fullnode.testnet.sui.io:443';

// クライアントを初期化
$client = new SuiRpcClient($rpcUrl);

// 基本的なオプションのみ設定
$options = new GetCheckpointsOptions();
$options->setLimit(5)
        ->setDescendingOrder(true); // 新しいチェックポイントから順に取得

try {
    echo "チェックポイントを取得中...\n";
    // チェックポイントのリストを取得
    $response = $client->getCheckpoints($options);

    // 結果を表示
    echo "チェックポイント一覧:\n";
    echo "総数: " . count($response->getData()) . "\n";
    echo "次のページがあるか: " . ($response->hasNextPage() ? 'はい' : 'いいえ') . "\n";
    echo "次のカーソル: " . ($response->getNextCursor() ?? 'なし') . "\n\n";

    foreach ($response->getData() as $index => $checkpoint) {
        echo "チェックポイント " . ($index + 1) . ":\n";
        echo "  シーケンス番号: " . $checkpoint->getSequenceNumber() . "\n";
        echo "  エポック: " . $checkpoint->getEpoch() . "\n";
        echo "  タイムスタンプ: " . date('Y-m-d H:i:s', $checkpoint->getTimestamp() / 1000) . "\n";
        echo "  ダイジェスト: " . $checkpoint->getDigest() . "\n";
        echo "\n";
    }

    // 次のページがある場合、カーソルを表示
    if ($response->hasNextPage() && $response->getNextCursor() !== null) {
        echo "次のカーソル値: " . $response->getNextCursor() . "\n";
    }
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage() . "\n";
    
    // デバッグ情報を追加
    echo "詳細情報:\n";
    echo "例外クラス: " . get_class($e) . "\n";
    if (method_exists($e, 'getTraceAsString')) {
        echo "スタックトレース:\n" . $e->getTraceAsString() . "\n";
    }
} 