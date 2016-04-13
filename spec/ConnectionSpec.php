<?php

namespace spec\Mattbit\MysqlCompat;

use PhpSpec\ObjectBehavior;
use Mattbit\MysqlCompat\Result;
use Mattbit\MysqlCompat\Exception\QueryException;

class ConnectionSpec extends ObjectBehavior
{
    protected $pdo;

    public function let($pdo)
    {
        $pdo->beADoubleOf(\PDO::class);
        $this->pdo = $pdo;
        $this->beConstructedWith($this->pdo);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Connection');
    }

    public function it_is_open_by_default()
    {
        $this->shouldBeOpen();
        $this->getPdo()->shouldReturn($this->pdo);
    }

    public function it_closes_correctly()
    {
        $this->close();
        $this->isOpen()->shouldReturn(false);
        $this->getPdo()->shouldReturn(null);
    }

    public function it_executes_valid_query($statement)
    {
        $statement->beADoubleOf('PDOStatement');

        $this->pdo->query('my test query')
                  ->shouldBeCalled()
                  ->willReturn($statement);

        $result = $this->query('my test query');

        $result->shouldBeAnInstanceOf(Result::class);
        $result->getStatement()->shouldEqual($statement);
    }

    public function it_throws_an_exception_if_query_is_not_valid()
    {
        $this->pdo->query('my wrong query')
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(QueryException::class)->duringQuery('my wrong query');
    }

    public function it_quotes_parameters()
    {
        $this->pdo->quote('my param')
                  ->shouldBeCalled()
                  ->willReturn("'my param'");

        $this->quote('my param')->shouldEqual("'my param'");
    }

    public function it_selects_database()
    {
        $this->pdo->query('USE mydb')
                  ->shouldBeCalled();

        $this->useDatabase('mydb');
    }

    public function it_returns_server_info()
    {
        $this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION)
                   ->willReturn('my fake server info');

        $this->getServerInfo()->shouldEqual('my fake server info');
    }
}
