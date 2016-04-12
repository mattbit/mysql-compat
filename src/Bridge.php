<?php

namespace Mattbit\MysqlCompat;

class Bridge
{
    /**
     * The database manager instance.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Create a new bridge.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
    [ ] `mysql_​close` (3)
    [ ] `mysql_​connect` (7)
    [ ] `mysql_​data_​seek` (1)
    [ ] `mysql_​errno` (2)
    [ ] `mysql_​error` (27)
    [ ] `mysql_​fetch_​array` (32)
    [ ] `mysql_​fetch_​assoc` (13)
    [ ] `mysql_​fetch_​field` (3)
    [ ] `mysql_​fetch_​object` (1)
    [ ] `mysql_​fetch_​row` (1)
    [ ] `mysql_​query` (30)
    [ ] `mysql_​real_​escape_​string` (11)
    [ ] `mysql_​result` (8)
    [ ] `mysql_​select_​db` (7)

     */

    public function connect()
    {

    }

    public function close()
    {

    }

    public function selectDb()
    {

    }

    public function errno()
    {

    }

    public function error()
    {

    }

    public function fetchArray()
    {

    }

    public function fetchAssoc()
    {

    }

    public function fetchField()
    {

    }

    public function fetchObject()
    {

    }

    public function fetchRow()
    {

    }

    public function query()
    {

    }

    public function realEscapeString()
    {

    }

    public function result()
    {

    }
}
