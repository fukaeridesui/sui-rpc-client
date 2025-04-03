<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

use Fukaeridesui\SuiRpcClient\Options\GetObjectOptions;
use Fukaeridesui\SuiRpcClient\Options\GetCheckpointsOptions;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;
use Fukaeridesui\SuiRpcClient\Responses\Read\ChainIdentifierResponse;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;
use Fukaeridesui\SuiRpcClient\Responses\Read\CheckpointResponse;
use Fukaeridesui\SuiRpcClient\Responses\Read\CheckpointsResponse;
use Fukaeridesui\SuiRpcClient\Responses\Read\EventsResponse;
use Fukaeridesui\SuiRpcClient\Responses\Read\LatestCheckpointSequenceNumberResponse;

interface ReadApiInterface
{
    /**
     * Get object by object ID
     *
     * @param string $objectId Object ID
     * @param GetObjectOptions|null $options Get options
     * @return ObjectResponseInterface Response object
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getObject(string $objectId, ?GetObjectOptions $options = null): ObjectResponseInterface;

    /**
     * Get multiple objects
     *
     * @param string[] $objectIds Array of object IDs
     * @param GetObjectOptions|null $options Get options
     * @return MultipleObjectsResponse Multiple objects response
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function getMultipleObjects(array $objectIds, ?GetObjectOptions $options = null): MultipleObjectsResponse;

    /**
     * Get chain identifier
     *
     * @return ChainIdentifierResponse Chain identifier response
     */
    public function getChainIdentifier(): ChainIdentifierResponse;

    /**
     * Get checkpoint.
     *
     * @param string $sequenceNumber Checkpoint sequence number
     * @return CheckpointResponse
     */
    public function getCheckpoint(string $sequenceNumber): CheckpointResponse;

    /**
     * Get checkpoints.
     *
     * @param GetCheckpointsOptions|null $options Options
     * @return CheckpointsResponse
     */
    public function getCheckpoints(?GetCheckpointsOptions $options = null): CheckpointsResponse;
    
    /**
     * Get events for a transaction.
     *
     * @param string $transactionDigest Transaction digest
     * @return EventsResponse Events response
     */
    public function getEvents(string $transactionDigest): EventsResponse;

    /**
     * Get the latest checkpoint sequence number
     *
     * @return LatestCheckpointSequenceNumberResponse Latest checkpoint sequence number
     */
    public function getLatestCheckpointSequenceNumber(): LatestCheckpointSequenceNumberResponse;
}
