<?php

class ErrorTest extends BridgeTestCase
{
    public function testErrno()
    {
        $this->bridge->query('SELECT * FROM test_table');
        $this->assertEquals(0, $this->bridge->errno());
        
        $this->bridge->query('SELECT * FROM nowhere');
        $this->assertEquals(1146, $this->bridge->errno());
    }

    public function testError()
    {
        $this->bridge->query('SELECT * FROM test_table');
        $this->assertEquals("", $this->bridge->error());

        $this->bridge->query('SELECT * FROM nowhere');
        $this->assertContains("doesn't exist", $this->bridge->error());
    }
}