<?php

use Mattbit\MysqlCompat\Mysql;

class MysqlTestCase extends FunctionalTestCase
{

    public function testDsnCanBeCustomized()
    {
        $dbname = $this->config['dbname'];
        $dbhost = $this->config['dbhost'];
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];
        $charset = 'latin1';

        $dsn ="mysql:dbname=$dbname;host=$dbhost;charset=$charset";
        Mysql::getManager()->connect($dsn, $dbuser, $dbpass);
        $result = Mysql::query('SHOW VARIABLES WHERE Variable_name = "character_set_connection"');
        $this->assertEquals($charset, Mysql::fetchAssoc($result)['Value']);

        $charset = 'gbk';
        $dsn ="mysql:dbname=$dbname;host=$dbhost;charset=$charset";
        Mysql::getManager()->connect($dsn, $dbuser, $dbpass);
        $result = Mysql::query('SHOW VARIABLES WHERE Variable_name = "character_set_connection"');
        $this->assertEquals($charset, Mysql::fetchAssoc($result)['Value']);
    }
}
