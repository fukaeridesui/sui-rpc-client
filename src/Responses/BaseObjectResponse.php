<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

abstract class BaseObjectResponse implements ObjectResponseInterface
{
    public readonly string $objectId;
    public readonly string $owner;
    public readonly ?string $type;
    public readonly array $content;

    // 追加プロパティ
    public readonly ?string $digest;
    public readonly ?string $version;
    public readonly ?int $storageRebate;
    public readonly ?string $previousTransaction;
    public readonly ?array $display;

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * オブジェクトのダイジェストを取得
     */
    public function getDigest(): ?string
    {
        return $this->digest;
    }

    /**
     * オブジェクトのバージョンを取得
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * ストレージリベートを取得
     */
    public function getStorageRebate(): ?int
    {
        return $this->storageRebate;
    }

    /**
     * 前回のトランザクションハッシュを取得
     */
    public function getPreviousTransaction(): ?string
    {
        return $this->previousTransaction;
    }

    /**
     * 表示データを取得
     */
    public function getDisplay(): ?array
    {
        return $this->display;
    }

    public function toArray(): array
    {
        $result = [
            'objectId' => $this->objectId,
            'owner' => $this->owner,
            'type' => $this->type,
            'content' => $this->content,
        ];

        // 追加プロパティが設定されている場合のみ含める
        if ($this->digest !== null) {
            $result['digest'] = $this->digest;
        }

        if ($this->version !== null) {
            $result['version'] = $this->version;
        }

        if ($this->storageRebate !== null) {
            $result['storageRebate'] = $this->storageRebate;
        }

        if ($this->previousTransaction !== null) {
            $result['previousTransaction'] = $this->previousTransaction;
        }

        if ($this->display !== null) {
            $result['display'] = $this->display;
        }

        return $result;
    }
}
