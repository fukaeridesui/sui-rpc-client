<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Checkpoints response with pagination.
 */
class CheckpointsResponse
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
     * Get checkpoint data.
     *
     * @return array
     */
    public function getData(): array
    {
        return array_map(function ($checkpoint) {
            return new CheckpointResponse($checkpoint);
        }, $this->data['data'] ?? []);
    }

    /**
     * Check if there is a next page.
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->data['hasNextPage'] ?? false;
    }

    /**
     * Get next cursor.
     *
     * @return string|null
     */
    public function getNextCursor(): ?string
    {
        return $this->data['nextCursor'] ?? null;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(function (CheckpointResponse $checkpoint) {
                return $checkpoint->toArray();
            }, $this->getData()),
            'hasNextPage' => $this->hasNextPage(),
            'nextCursor' => $this->getNextCursor(),
        ];
    }
} 