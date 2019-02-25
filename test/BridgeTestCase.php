<?php

use Mattbit\MysqlCompat\Bridge;
use Mattbit\MysqlCompat\Manager;

class BridgeTestCase extends FunctionalTestCase
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var Bridge
     */
    protected $bridge;

    /**
     * @var \PDO
     */
    protected $db;

    public function setUp()
    {
        $this->manager = new Manager(new \Mattbit\MysqlCompat\ConnectionFactory());
        $this->bridge = new Bridge($this->manager);

        $this->bridge->connect($this->config['dbhost'], $this->config['dbuser'], $this->config['dbpass']);
        $this->bridge->selectDb($this->config['dbname']);

        $this->loadFixtures();
    }

    protected function loadFixtures()
    {
        $dbname = $this->config['dbname'];
        $dbhost = $this->config['dbhost'];
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];

        $this->db = new PDO("mysql:dbname=$dbname;host=$dbhost", $dbuser, $dbpass);
        $sql = file_get_contents(__DIR__.'/fixtures.sql');
        $this->db->query($sql);
    }
}
