<?php

class RowCountTest extends BridgeTestCase
{
    public function testUpdateAffectedRows()
    {
        $this->bridge->query("UPDATE test_table SET testfield = 'updated' WHERE id > 100");
        $this->assertEquals(0, $this->bridge->affectedRows());

        $this->bridge->query("UPDATE test_table SET testfield = 'updated' WHERE id > 5");
        $this->assertEquals(5, $this->bridge->affectedRows());
    }

    public function testInsertAffectedRows()
    {
        $this->assertEquals(0, $this->bridge->affectedRows());

        $this->bridge->query("INSERT INTO test_table VALUES (100, 'test insert 100')");
        $this->assertEquals(1, $this->bridge->affectedRows());

        $this->bridge->query("INSERT INTO test_table VALUES (101, 'test insert 101'), (102, 'test insert 102')");
        $this->assertEquals(2, $this->bridge->affectedRows());
    }

    public function testDeleteAffectedRows()
    {
        $this->assertEquals(0, $this->bridge->affectedRows());

        $this->bridge->query('DELETE FROM test_table WHERE id = 1');
        $this->assertEquals(1, $this->bridge->affectedRows());

        $this->bridge->query('DELETE FROM test_table WHERE id > 5');
        $this->assertEquals(5, $this->bridge->affectedRows());
    }

    public function testNumRows()
    {
        $result = $this->bridge->query('SELECT * FROM test_table WHERE id > 100');
        $this->assertEquals(0, $this->bridge->numRows($result));

        $result = $this->bridge->query('SELECT id FROM test_table where id < 5');
        $this->assertEquals(4, $this->bridge->numRows($result));
    }
}
