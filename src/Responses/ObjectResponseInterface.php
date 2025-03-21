<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

/**
 * Sui オブジェクトレスポンスインターフェース
 */
interface ObjectResponseInterface
{
    /**
     * オブジェクトIDを取得
     */
    public function getObjectId(): string;

    /**
     * オブジェクト所有者を取得
     */
    public function getOwner(): string;

    /**
     * オブジェクトの型を取得
     */
    public function getType(): ?string;

    /**
     * オブジェクトの内容を取得
     */
    public function getContent(): array;

    /**
     * オブジェクトのダイジェストを取得
     */
    public function getDigest(): ?string;

    /**
     * オブジェクトのバージョンを取得
     */
    public function getVersion(): ?string;

    /**
     * ストレージリベートを取得
     */
    public function getStorageRebate(): ?int;

    /**
     * 前回のトランザクションハッシュを取得
     */
    public function getPreviousTransaction(): ?string;

    /**
     * 表示データを取得
     */
    public function getDisplay(): ?array;

    /**
     * レスポンスを配列に変換
     */
    public function toArray(): array;
}
