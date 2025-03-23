<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;

/**
 * Collection class that holds multiple object responses
 * 
 * This class manages multiple ObjectResponseInterface instances and
 * provides methods to access them.
 * It handles responses from the sui_multiGetObjects API call.
 */
class MultipleObjectsResponse
{
    /**
     * @var ObjectResponseInterface[] Array of objects
     */
    private array $objects;

    /**
     * @param ObjectResponseInterface[] $objects Array of objects
     */
    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    /**
     * Get all objects
     *
     * @return ObjectResponseInterface[] Array of objects
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * Get object at specified index
     *
     * @param int $index Index
     * @return ObjectResponseInterface|null Object or null (if index is out of range)
     */
    public function getObjectAt(int $index): ?ObjectResponseInterface
    {
        return $this->objects[$index] ?? null;
    }

    /**
     * Get number of objects
     *
     * @return int Number of objects
     */
    public function count(): int
    {
        return count($this->objects);
    }

    /**
     * Get IDs of all objects
     *
     * @return string[] Array of object IDs
     */
    public function getObjectIds(): array
    {
        return array_map(function (ObjectResponseInterface $obj) {
            return $obj->getObjectId();
        }, $this->objects);
    }

    /**
     * Get all objects as array
     *
     * @return array Array of objects
     */
    public function toArray(): array
    {
        return array_map(function (ObjectResponseInterface $obj) {
            return $obj->toArray();
        }, $this->objects);
    }

    /**
     * Find object by ID
     *
     * @param string $objectId Object ID to search for
     * @return ObjectResponseInterface|null Found object or null
     */
    public function findById(string $objectId): ?ObjectResponseInterface
    {
        foreach ($this->objects as $object) {
            if ($object->getObjectId() === $objectId) {
                return $object;
            }
        }
        return null;
    }
}
