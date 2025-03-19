<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

class GetObjectResponse
{
    public readonly string $objectId;
    public readonly string $owner;
    public readonly ?string $type;
    public readonly array $content;

    public function __construct(array $response)
    {
        // 期待するレスポンス構造のパース
        $this->objectId = $response['data']['objectId'];
        $this->owner = $response['data']['owner']['AddressOwner'] ?? 'Unknown';
        $this->type = $response['data']['type'] ?? null;
        $this->content = $response['data']['content'] ?? [];
    }

    // 任意：オブジェクト → 配列化も実装可能
    public function toArray(): array
    {
        return [
            'objectId' => $this->objectId,
            'owner' => $this->owner,
            'type' => $this->type,
            'content' => $this->content,
        ];
    }
}
