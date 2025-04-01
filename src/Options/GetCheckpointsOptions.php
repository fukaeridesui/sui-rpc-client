<?php

namespace Fukaeridesui\SuiRpcClient\Options;

/**
 * Get checkpoints options.
 */
class GetCheckpointsOptions
{
    private ?string $cursor = null;
    private ?int $limit = null;
    private ?bool $descendingOrder = null;

    /**
     * Set cursor.
     *
     * @param string $cursor Pagination cursor
     * @return self
     */
    public function setCursor(string $cursor): self
    {
        $this->cursor = $cursor;
        return $this;
    }

    /**
     * Set limit.
     *
     * @param int $limit Pagination limit
     * @return self
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set descending order.
     *
     * @param bool $descendingOrder Whether to return results in descending order
     * @return self
     */
    public function setDescendingOrder(bool $descendingOrder): self
    {
        $this->descendingOrder = $descendingOrder;
        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->cursor !== null) {
            $result['cursor'] = $this->cursor;
        }

        if ($this->limit !== null) {
            $result['limit'] = $this->limit;
        }

        if ($this->descendingOrder !== null) {
            $result['descendingOrder'] = $this->descendingOrder;
        }

        return $result;
    }
} 