<?php

use Mattbit\MysqlCompat\Result;

class FetchTest extends BridgeTestCase
{
    public function testFetchArray()
    {
        $query = 'SELECT * FROM test_table WHERE id <= 3';
        $result = $this->bridge->query($query);

        $this->assertEquals(
            [
                0           => "1",
                1           => "test 1",
                "id"        => "1",
                "testfield" => "test 1",
            ],
            $this->bridge->fetchArray($result)
        );

        $this->assertEquals(
            [
                "id"        => "2",
                "testfield" => "test 2",
            ],
            $this->bridge->fetchArray($result, Result::FETCH_ASSOC)
        );

        $this->assertEquals(
            [
                0 => "3",
                1 => "test 3",
            ],
            $this->bridge->fetchArray($result, MYSQL_NUM)
        );
        
        $this->assertFalse($this->bridge->fetchArray($result));
    }

    public function testFetchAssoc()
    {
        $query = 'SELECT * FROM test_table WHERE id = 4';
        $result = $this->bridge->query($query);

        $this->assertEquals(
            [
                'id'        => '4',
                'testfield' => 'test 4'
            ],
            $this->bridge->fetchAssoc($result)
        );
    }

    public function testFetchField()
    {
        $query = 'SELECT * FROM test_table';
        $result = $this->bridge->query($query);

        $this->assertAttributeEquals(1, 'primary_key', $this->bridge->fetchField($result));
        $this->assertAttributeEquals('id', 'name', $this->bridge->fetchField($result));
        $this->assertAttributeEquals('testfield', 'name', $this->bridge->fetchField($result, 1));
    }

    public function testFetchLengths()
    {
        $query = 'SELECT * FROM test_table WHERE id = 10';
        $result = $this->bridge->query($query);
        $this->bridge->fetchAssoc($result);

        $this->assertEquals([0 => 2, 1 => 7], $this->bridge->fetchLengths($result));
    }

    public function testFetchObject()
    {
        $query = 'SELECT * FROM test_table WHERE id = 5';
        $result = $this->bridge->query($query);

        $object = $this->bridge->fetchObject($result);

        $this->assertInstanceOf(stdClass::class, $object);
        $this->assertEquals('5', $object->id);
        $this->assertEquals('test 5', $object->testfield);

        $query = 'SELECT * FROM test_table WHERE id = 5';
        $result = $this->bridge->query($query);

        $object = $this->bridge->fetchObject($result, DummyObject::class, [1, 2]);

        $this->assertInstanceOf(DummyObject::class, $object);
        $this->assertEquals('5', $object->id);
        $this->assertEquals('test 5', $object->testfield);
        $this->assertEquals(1, $object->one);
        $this->assertEquals(2, $object->two);
    }

    public function testFetchRow()
    {
        $query = 'SELECT * FROM test_table WHERE id = 6';
        $result = $this->bridge->query($query);

        $this->assertEquals(
            [
                0 => '6',
                1 => 'test 6'
            ],
            $this->bridge->fetchRow($result)
        );
    }

    /** @expectedException \Mattbit\MysqlCompat\Exception\NotSupportedException */
    public function testDataSeek()
    {
        $result = $this->bridge->query('SELECT * FROM test_table');

        $this->bridge->dataSeek($result, 5);
    }
}

class DummyObject {
    public $one;
    public $two;
    public function __construct($one, $two)
    {
        $this->one = $one;
        $this->two = $two;
    }
}