<?php

namespace Fukaeridesui\SuiRpcClient\Tests;

use PHPUnit\Framework\TestCase;
use Fukaeridesui\SuiRpcClient\Responses\Read\MultipleObjectsResponse;
use Fukaeridesui\SuiRpcClient\Responses\ObjectResponseInterface;

class MultipleObjectsResponseTest extends TestCase
{
    public function testCountReturnsCorrectNumberOfObjects()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj2 = $this->createMock(ObjectResponseInterface::class);

        $response = new MultipleObjectsResponse([$obj1, $obj2]);

        $this->assertEquals(2, $response->count());
    }

    public function testGetObjectsReturnsAllObjects()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj2 = $this->createMock(ObjectResponseInterface::class);

        $objects = [$obj1, $obj2];
        $response = new MultipleObjectsResponse($objects);

        $this->assertSame($objects, $response->getObjects());
    }

    public function testGetObjectAtReturnsCorrectObject()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj2 = $this->createMock(ObjectResponseInterface::class);

        $response = new MultipleObjectsResponse([$obj1, $obj2]);

        $this->assertSame($obj1, $response->getObjectAt(0));
        $this->assertSame($obj2, $response->getObjectAt(1));
        $this->assertNull($response->getObjectAt(2));
    }

    public function testGetObjectIdsReturnsCorrectIds()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj1->method('getObjectId')->willReturn('0x123');

        $obj2 = $this->createMock(ObjectResponseInterface::class);
        $obj2->method('getObjectId')->willReturn('0x456');

        $response = new MultipleObjectsResponse([$obj1, $obj2]);

        $this->assertEquals(['0x123', '0x456'], $response->getObjectIds());
    }

    public function testToArrayReturnsArrayOfAllObjects()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj1->method('toArray')->willReturn(['objectId' => '0x123']);

        $obj2 = $this->createMock(ObjectResponseInterface::class);
        $obj2->method('toArray')->willReturn(['objectId' => '0x456']);

        $response = new MultipleObjectsResponse([$obj1, $obj2]);

        $expected = [
            ['objectId' => '0x123'],
            ['objectId' => '0x456']
        ];

        $this->assertEquals($expected, $response->toArray());
    }

    public function testFindByIdReturnsCorrectObject()
    {
        $obj1 = $this->createMock(ObjectResponseInterface::class);
        $obj1->method('getObjectId')->willReturn('0x123');

        $obj2 = $this->createMock(ObjectResponseInterface::class);
        $obj2->method('getObjectId')->willReturn('0x456');

        $response = new MultipleObjectsResponse([$obj1, $obj2]);

        $this->assertSame($obj1, $response->findById('0x123'));
        $this->assertSame($obj2, $response->findById('0x456'));
        $this->assertNull($response->findById('0x789'));
    }

    public function testEmptyResponseBehavior()
    {
        $response = new MultipleObjectsResponse([]);

        $this->assertEquals(0, $response->count());
        $this->assertEquals([], $response->getObjects());
        $this->assertEquals([], $response->getObjectIds());
        $this->assertEquals([], $response->toArray());
        $this->assertNull($response->getObjectAt(0));
        $this->assertNull($response->findById('0x123'));
    }
}
