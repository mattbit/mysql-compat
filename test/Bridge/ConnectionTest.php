<?php

class ConnectionTest extends BridgeTestCase
{
    public function testDsnCanBeCustomized()
    {
        $dbname = $this->config['dbname'];
        $dbhost = $this->config['dbhost'];
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];

        $dsn ="mysql:dbname=$dbname;host=$dbhost;charset=latin1";
        $this->manager->connect($dsn, $dbuser, $dbpass);
        $result = $this->bridge->query('SHOW VARIABLES LIKE "character_set_connection"');
        $this->assertEquals('latin1', $result->fetch()['Value']);

        $dsn ="mysql:dbname=$dbname;host=$dbhost;charset=gbk";
        $this->manager->connect($dsn, $dbuser, $dbpass);
        $result = $this->bridge->query('SHOW VARIABLES LIKE "character_set_connection"');
        $this->assertEquals('gbk', $result->fetch()['Value']);
    }
}
