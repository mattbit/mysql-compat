<?php

namespace spec\Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\QueryException;
use Mattbit\MysqlCompat\Result;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionSpec extends ObjectBehavior
{
    protected $pdo;

    function let($pdo)
    {
        $pdo->beADoubleOf(\PDO::class);
        $this->pdo = $pdo;
        $this->beConstructedWith($this->pdo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Connection');
    }


    function it_is_open_by_default()
    {
        $this->shouldBeOpen();
        $this->getPdo()->shouldReturn($this->pdo);
    }

    function it_closes_correctly()
    {
        $this->close();
        $this->isOpen()->shouldReturn(false);
        $this->getPdo()->shouldReturn(null);
    }

    function it_executes_valid_query($statement)
    {
        $statement->beADoubleOf('PDOStatement');

        $this->pdo->query('my test query')
                  ->shouldBeCalled()
                  ->willReturn($statement);

        $result = $this->query('my test query');

        $result->shouldBeAnInstanceOf(Result::class);
        $result->getStatement()->shouldEqual($statement);
    }

    function it_throws_an_exception_if_query_is_not_valid()
    {
        $this->pdo->query('my wrong query')
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(QueryException::class)->duringQuery('my wrong query');
    }

    function it_escapes_correctly()
    {
        foreach ($this->getEscapingData() as $arg) {
            $this->pdo->quote($arg[1])
                      ->shouldBeCalled()
                      ->willReturn($arg[2]);

            $this->escape($arg[1])->shouldEqual($arg[0]);
        }
    }

    public function it_selects_database()
    {
        $this->pdo->query('use mydb')
                  ->shouldBeCalled();

        $this->useDatabase('mydb');
    }

    public function it_returns_server_info()
    {
        $this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION)
                   ->willReturn('my fake server info');

        $this->getServerInfo()->shouldEqual('my fake server info');
    }

    protected function getEscapingData()
    {
        return [
            ['%value%', '%value%', "'%value%'"],
            ["\\' wrong quote", "' wrong quote", "'\\' wrong quote'"],
            ["\\'\\'", "''", "'\\'\\''"]
        ];
    }
}
