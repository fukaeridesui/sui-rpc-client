<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Checkpoint response.
 */
class CheckpointResponse
{
    private array $data;

    /**
     * @param array $data API response data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get digest.
     *
     * @return string
     */
    public function getDigest(): string
    {
        return $this->data['digest'];
    }

    /**
     * Get sequence number.
     *
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return (int)$this->data['sequenceNumber'];
    }

    /**
     * Get epoch.
     *
     * @return int
     */
    public function getEpoch(): int
    {
        return (int)$this->data['epoch'];
    }

    /**
     * Get timestamp.
     *
     * @return int
     */
    public function getTimestamp(): int
    {
        return (int)($this->data['timestampMs'] ?? 0);
    }

    /**
     * Get previous digest.
     *
     * @return string|null
     */
    public function getPreviousDigest(): ?string
    {
        return $this->data['previousDigest'] ?? null;
    }

    /**
     * Get epoch rolling gas cost summary.
     *
     * @return array
     */
    public function getEpochRollingGasCostSummary(): array
    {
        return $this->data['epochRollingGasCostSummary'] ?? [];
    }

    /**
     * Get network total transactions.
     *
     * @return int
     */
    public function getNetworkTotalTransactions(): int
    {
        return (int)($this->data['networkTotalTransactions'] ?? 0);
    }

    /**
     * Get rolling gas summary.
     *
     * @return array
     */
    public function getRollingGasSummary(): array
    {
        return $this->data['rollingGasSummary'] ?? [];
    }

    /**
     * Get epoch to date.
     *
     * @return array
     */
    public function getEpochToDate(): array
    {
        return $this->data['epochToDate'] ?? [];
    }

    /**
     * Get end of epoch data.
     *
     * @return array|null
     */
    public function getEndOfEpochData(): ?array
    {
        return $this->data['endOfEpochData'] ?? null;
    }

    /**
     * Get validator signature.
     *
     * @return array
     */
    public function getValidatorSignature(): array
    {
        return $this->data['validatorSignature'] ?? [];
    }

    /**
     * Get transaction digests.
     *
     * @return array
     */
    public function getTransactionDigests(): array
    {
        return $this->data['transactionDigests'] ?? [];
    }

    /**
     * Get checkpoint commitments.
     *
     * @return array
     */
    public function getCheckpointCommitments(): array
    {
        return $this->data['checkpointCommitments'] ?? [];
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'digest' => $this->getDigest(),
            'sequenceNumber' => $this->getSequenceNumber(),
            'epoch' => $this->getEpoch(),
            'timestamp' => $this->getTimestamp(),
            'previousDigest' => $this->getPreviousDigest(),
            'epochRollingGasCostSummary' => $this->getEpochRollingGasCostSummary(),
            'networkTotalTransactions' => $this->getNetworkTotalTransactions(),
            'rollingGasSummary' => $this->getRollingGasSummary(),
            'epochToDate' => $this->getEpochToDate(),
            'endOfEpochData' => $this->getEndOfEpochData(),
            'validatorSignature' => $this->getValidatorSignature(),
            'transactionDigests' => $this->getTransactionDigests(),
            'checkpointCommitments' => $this->getCheckpointCommitments()
        ];
    }
} 