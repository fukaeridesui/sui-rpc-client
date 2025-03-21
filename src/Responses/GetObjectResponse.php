<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

use Fukaeridesui\SuiRpcClient\Responses\BaseObjectResponse;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class GetObjectResponse extends BaseObjectResponse
{
    /**
     * @param array $response レスポンスデータ
     * @throws SuiRpcException 不正なレスポンス構造の場合
     */
    public function __construct(array $response)
    {
        if (!isset($response['data'])) {
            throw new SuiRpcException(null, 'Invalid response: missing data field');
        }

        $data = $response['data'];

        if (!isset($data['objectId'])) {
            throw new SuiRpcException(null, 'Invalid response: missing objectId field');
        }

        $this->objectId = $data['objectId'];

        // owner フィールドは複数の形式でありうる
        if (isset($data['owner'])) {
            if (isset($data['owner']['AddressOwner'])) {
                $this->owner = $data['owner']['AddressOwner'];
            } elseif (isset($data['owner']['ObjectOwner'])) {
                $this->owner = 'Object: ' . $data['owner']['ObjectOwner'];
            } elseif (isset($data['owner']['Shared'])) {
                $this->owner = 'Shared';
            } elseif (isset($data['owner']['Immutable'])) {
                $this->owner = 'Immutable';
            } else {
                $this->owner = 'Unknown: ' . json_encode($data['owner']);
            }
        } else {
            $this->owner = 'Unknown';
        }

        $this->type = $data['type'] ?? null;
        $this->content = $data['content'] ?? [];

        // 追加情報があれば保存
        $this->digest = $data['digest'] ?? null;
        $this->version = $data['version'] ?? null;
        $this->storageRebate = isset($data['storageRebate']) ? (int)$data['storageRebate'] : null;
        $this->previousTransaction = $data['previousTransaction'] ?? null;
        $this->display = $data['display'] ?? null;
    }
}
