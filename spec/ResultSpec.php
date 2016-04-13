<?php

namespace spec\Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Connection;
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    protected $statement;

    protected $connection;

    public function let($statement, $connection)
    {
        $statement->beADoubleOf(\PDOStatement::class);
        $this->statement = $statement;

        $connection->beADoubleOf(Connection::class);
        $this->connection = $connection;

        $this->beConstructedWith($this->statement, $this->connection);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Result');
    }
}
