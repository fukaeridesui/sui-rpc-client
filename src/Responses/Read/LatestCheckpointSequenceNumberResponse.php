<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Response for the latest checkpoint sequence number
 */
class LatestCheckpointSequenceNumberResponse
{
    private string $sequenceNumber;

    /**
     * Constructor
     *
     * @param string $sequenceNumber The latest checkpoint sequence number
     */
    public function __construct(string $sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
    }

    /**
     * Get the latest checkpoint sequence number
     *
     * @return string The latest checkpoint sequence number
     */
    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    /**
     * Convert to string
     *
     * @return string The latest checkpoint sequence number as a string
     */
    public function __toString(): string
    {
        return $this->sequenceNumber;
    }
} 