<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

/**
 * Response class representing a single Sui object
 * 
 * This class processes the response from the sui_getObject API call.
 * It implements ObjectResponseInterface and converts API response data into an easily usable form.
 */
class GetObjectResponse implements ObjectResponseInterface
{
    public readonly string $objectId;
    public readonly string $owner;
    public readonly ?string $type;
    public readonly array $content;

    // additional properties
    public readonly ?string $digest;
    public readonly ?string $version;
    public readonly ?int $storageRebate;
    public readonly ?string $previousTransaction;
    public readonly ?array $display;

    /**
     * Construct a new object from API response
     * 
     * @param array $response API response data
     * @throws SuiRpcException If the response structure is invalid
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

        // owner field can have multiple formats
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

        // additional information if exists
        $this->digest = $data['digest'] ?? null;
        $this->version = $data['version'] ?? null;
        $this->storageRebate = isset($data['storageRebate']) ? (int)$data['storageRebate'] : null;
        $this->previousTransaction = $data['previousTransaction'] ?? null;
        $this->display = $data['display'] ?? null;
    }

    /**
     * Get object ID
     *
     * @return string Object ID
     */
    public function getObjectId(): string
    {
        return $this->objectId;
    }

    /**
     * Get object owner
     *
     * @return string Owner information
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * Get object type
     *
     * @return string|null Object type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get object content
     *
     * @return array Object content
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Get object digest
     *
     * @return string|null Digest
     */
    public function getDigest(): ?string
    {
        return $this->digest;
    }

    /**
     * Get object version
     *
     * @return string|null Version
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * Get storage rebate
     *
     * @return int|null Storage rebate
     */
    public function getStorageRebate(): ?int
    {
        return $this->storageRebate;
    }

    /**
     * Get previous transaction hash
     *
     * @return string|null Transaction hash
     */
    public function getPreviousTransaction(): ?string
    {
        return $this->previousTransaction;
    }

    /**
     * Get display data
     *
     * @return array|null Display data
     */
    public function getDisplay(): ?array
    {
        return $this->display;
    }

    /**
     * Get object as array
     *
     * @return array Object data
     */
    public function toArray(): array
    {
        $result = [
            'objectId' => $this->objectId,
            'owner' => $this->owner,
            'type' => $this->type,
            'content' => $this->content,
        ];

        // Include additional properties only if they are set
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
