<?php

namespace spec\Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Connection;
use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    protected $statement;

    protected $connection;

    function let($statement, $connection)
    {
        $statement->beADoubleOf(\PDOStatement::class);
        $this->statement = $statement;

        $connection->beADoubleOf(Connection::class);
        $this->connection = $connection;

        $this->beConstructedWith($this->statement, $this->connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Result');
    }
}
