<?php

namespace Fukaeridesui\SuiRpcClient;

use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;

/**
 * Sui JSON-RPC クライアントインターフェース
 */
interface SuiRpcClientInterface
{
    /**
     * オブジェクトIDによってオブジェクトを取得
     *
     * @param string $objectId 取得するオブジェクトのID
     * @param GetObjectOptions|null $options 取得オプション
     * @return ObjectResponseInterface レスポンスオブジェクト
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException RPCエラー発生時
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface;

    /**
     * クライアントの基本URLを取得
     *
     * @return string RPC URL
     */
    public function getRpcUrl(): string;
}
