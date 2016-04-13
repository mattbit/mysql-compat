<?php

class InsertTest extends BridgeTestCase
{
    public function testLastInsertedId()
    {
        $this->assertEquals(0, $this->bridge->insertId());
        
        $this->bridge->query('INSERT INTO test_table VALUES (100, "test insert")');
        $this->assertEquals(100, $this->bridge->insertId());

        $this->bridge->query('INSERT INTO test_table (testfield) VALUES ("test insert")');
        $this->assertEquals(101, $this->bridge->insertId());
    }
}