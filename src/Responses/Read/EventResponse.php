<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Event response.
 */
class EventResponse
{
    private string $id;
    private string $packageId;
    private array $parsedJson;
    private string $sender;
    private string $timestampMs;
    private string $transactionModule;
    private string $type;
    private array $rawData;

    /**
     * @param array $data Event data
     */
    public function __construct(array $data)
    {
        echo 'Hello world!!'; var_dump($data);exit;
        $this->id = $data['id'] ?? '';
        $this->packageId = $data['packageId'] ?? '';
        $this->transactionModule = $data['transactionModule'] ?? '';
        $this->sender = $data['sender'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->timestampMs = $data['timestampMs'] ?? '';
        $this->parsedJson = $data['parsedJson'] ?? [];
        $this->rawData = $data;
    }

    /**
     * Get ID.
     *
     * @return string Event ID
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get package ID.
     *
     * @return string Package ID
     */
    public function getPackageId(): string
    {
        return $this->packageId;
    }

    /**
     * Get transaction module.
     *
     * @return string Transaction module
     */
    public function getTransactionModule(): string
    {
        return $this->transactionModule;
    }

    /**
     * Get sender.
     *
     * @return string Sender address
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * Get type.
     *
     * @return string Event type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get timestamp in milliseconds.
     *
     * @return string Timestamp in milliseconds
     */
    public function getTimestampMs(): string
    {
        return $this->timestampMs;
    }

    /**
     * Get parsed JSON.
     *
     * @return array Parsed JSON
     */
    public function getParsedJson(): array
    {
        return $this->parsedJson;
    }

    /**
     * Get raw data.
     *
     * @return array Raw data
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }
} 