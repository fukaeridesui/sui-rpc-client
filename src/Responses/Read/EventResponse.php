<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Event response.
 */
class EventResponse
{
    private string $txDigest;
    private string $eventSeq;
    private string $packageId;
    private array $parsedJson;
    private string $sender;
    private string $timestampMs;
    private string $transactionModule;
    private string $type;
    private string $bcsEncoding;
    private string $bcs;
    private array $rawData;

    /**
     * @param array $data Event data
     */
    public function __construct(array $data)
    {
        if (isset($data['id']) && is_array($data['id'])) {
            $this->txDigest = $data['id']['txDigest'] ?? '';
            $this->eventSeq = $data['id']['eventSeq'] ?? '';
        } else {
            $this->txDigest = '';
            $this->eventSeq = '';
        }

        $this->packageId = $data['packageId'] ?? '';
        $this->parsedJson = $data['parsedJson'] ?? [];
        $this->sender = $data['sender'] ?? '';
        $this->timestampMs = $data['timestampMs'] ?? '';
        $this->transactionModule = $data['transactionModule'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->bcsEncoding = $data['bcsEncoding'] ?? '';
        $this->bcs = $data['bcs'] ?? '';
        $this->rawData = $data;
    }

    /**
     * Get transaction digest.
     *
     * @return string Transaction digest
     */
    public function getTxDigest(): string
    {
        return $this->txDigest;
    }

    /**
     * Get event sequence.
     *
     * @return string Event sequence
     */
    public function getEventSeq(): string
    {
        return $this->eventSeq;
    }

    /**
     * Get ID in string format (for backwards compatibility).
     *
     * @return string Event ID in format "txDigest:eventSeq"
     */
    public function getId(): string
    {
        if (empty($this->txDigest)) {
            return '';
        }

        return $this->txDigest . ':' . $this->eventSeq;
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
     * Get BCS encoding.
     *
     * @return string BCS encoding
     */
    public function getBcsEncoding(): string
    {
        return $this->bcsEncoding;
    }

    /**
     * Get BCS.
     *
     * @return string BCS
     */
    public function getBcs(): string
    {
        return $this->bcs;
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
