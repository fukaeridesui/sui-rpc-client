<?php

namespace Fukaeridesui\SuiRpcClient\Responses;

/**
 * multiple objects response
 */
class MultipleObjectsResponse
{
    /**
     * @var ObjectResponseInterface[] objects
     */
    private array $objects;

    /**
     * @param ObjectResponseInterface[] $objects objects
     */
    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    /**
     * get objects
     *
     * @return ObjectResponseInterface[]
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * get object at index
     *
     * @param int $index index
     * @return ObjectResponseInterface|null object at index or null
     */
    public function getObjectAt(int $index): ?ObjectResponseInterface
    {
        return $this->objects[$index] ?? null;
    }

    /**
     * get number of objects
     *
     * @return int number of objects
     */
    public function count(): int
    {
        return count($this->objects);
    }

    /**
     * get object ids
     *
     * @return string[] object ids
     */
    public function getObjectIds(): array
    {
        return array_map(function (ObjectResponseInterface $obj) {
            return $obj->getObjectId();
        }, $this->objects);
    }

    /**
     * get all objects as array
     *
     * @return array objects as array
     */
    public function toArray(): array
    {
        return array_map(function (ObjectResponseInterface $obj) {
            return $obj->toArray();
        }, $this->objects);
    }

    /**
     * find object by object id
     *
     * @param string $objectId object id
     * @return ObjectResponseInterface|null found object or null
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
