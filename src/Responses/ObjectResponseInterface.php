<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

/**
 * Sui Object Response Interface
 */
interface ObjectResponseInterface
{
    /**
     * Get Object ID
     */
    public function getObjectId(): string;

    /**
     * Get Object Owner
     */
    public function getOwner(): string;

    /**
     * Get Object Type
     */
    public function getType(): ?string;

    /**
     * Get Object Content
     */
    public function getContent(): array;

    /**
     * Get Object Digest
     */
    public function getDigest(): ?string;

    /**
     * Get Object Version
     */
    public function getVersion(): ?string;

    /**
     * Get Storage Rebate
     */
    public function getStorageRebate(): ?int;

    /**
     * Get Previous Transaction Hash
     */
    public function getPreviousTransaction(): ?string;

    /**
     * Get Display Data
     */
    public function getDisplay(): ?array;

    /**
     * Convert Response to Array
     */
    public function toArray(): array;
}
