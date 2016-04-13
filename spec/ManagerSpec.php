<?php

namespace spec\Mattbit\MysqlCompat;

use PhpSpec\ObjectBehavior;
use Mattbit\MysqlCompat\Connection;
use Mattbit\MysqlCompat\ConnectionFactory;
use Mattbit\MysqlCompat\Exception\NoConnectionException;
use Mattbit\MysqlCompat\Exception\ClosedConnectionException;

class ManagerSpec extends ObjectBehavior
{
    protected $connectionFactory;

    public function let($connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->connectionFactory->beADoubleOf(ConnectionFactory::class);
        $this->beConstructedWith($connectionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Manager');
    }

    public function it_manages_connections($connection_0, $connection_1)
    {
        $connection_0->beADoubleOf(Connection::class);
        $connection_1->beADoubleOf(Connection::class);

        $this->connectionFactory->createConnection('dsn_0', 'username_0', 'password_0', [])
                                ->shouldBeCalledTimes(1)
                                ->willReturn($connection_0);

        $this->connect('dsn_0', 'username_0', 'password_0')
             ->shouldReturn($connection_0);

        $this->connectionFactory->createConnection('dsn_1', 'username_1', 'password_1', [])
                                ->shouldBeCalledTimes(1)
                                ->willReturn($connection_1);

        $this->connect('dsn_1', 'username_1', 'password_1')
             ->shouldReturn($connection_1);

        $this->connect('dsn_1', 'username_1', 'password_1')
             ->shouldReturn($connection_1);

        $this->getConnections()->shouldHaveCount(2);
        $this->getConnections()->shouldContain($connection_0);
        $this->getConnections()->shouldContain($connection_1);

        $this->getLastConnection()->shouldReturn($connection_1);

        $connection_1->close()->shouldBeCalled();
        $this->disconnect($connection_1);

        $this->getConnections()->shouldHaveCount(1);
        $this->getConnections()->shouldNotContain($connection_1);

        $connection_0->close()->shouldBeCalled();
        $this->disconnect();
        $this->getConnections()->shouldHaveCount(0);
    }

    public function it_returns_the_last_connection($connection_0, $connection_1)
    {
        $connection_0->beADoubleOf(Connection::class);
        $connection_1->beADoubleOf(Connection::class);

        $this->connectionFactory->createConnection('dsn_0', 'username_0', 'password_0', [])
            ->shouldBeCalledTimes(1)
            ->willReturn($connection_0);

        $this->connectionFactory->createConnection('dsn_1', 'username_1', 'password_1', [])
            ->shouldBeCalledTimes(1)
            ->willReturn($connection_1);

        $this->connect('dsn_0', 'username_0', 'password_0');
        $this->connect('dsn_1', 'username_1', 'password_1');

        $this->getLastConnection()->shouldReturn($connection_1);

        $this->connect('dsn_0', 'username_0', 'password_0');

        $this->getLastConnection()->shouldReturn($connection_0);
    }

    public function it_creates_a_new_connection_if_forced($connection_0, $connection_1)
    {
        $connection_0->beADoubleOf(Connection::class);
        $connection_1->beADoubleOf(Connection::class);

        $this->connectionFactory->createConnection('dsn_0', 'username_0', 'password_0', [])
            ->shouldBeCalledTimes(2)
            ->willReturn($connection_0, $connection_1);

        $this->connect('dsn_0', 'username_0', 'password_0');
        $this->connect('dsn_0', 'username_0', 'password_0', [], true);

        $this->getLastConnection()->shouldReturn($connection_1);
    }

    public function it_returns_open_connections($connection)
    {
        $connection->beADoubleOf(Connection::class);
        $connection->isOpen()->willReturn(true);

        $this->getOpenConnectionOrFail($connection)->shouldEqual($connection);

        $connection->isOpen()->willReturn(false);

        $this->shouldThrow(ClosedConnectionException::class)
             ->duringGetOpenConnectionOrFail($connection);

        $this->shouldThrow(NoConnectionException::class)
             ->duringGetOpenConnectionOrFail();
    }

    public function it_executes_query($connection)
    {
        $connection = $this->setUpConnection($connection);
        $connection->query('my query')->shouldBeCalled();

        $this->query('my query');
    }

    public function it_selects_database($connection)
    {
        $connection = $this->setUpConnection($connection);
        $connection->useDatabase('db')->shouldBeCalled();

        $this->useDatabase('db');
    }

    public function it_checks_connection_status($openConnection, $closedConnection)
    {
        $openConnection->beADoubleOf(Connection::class);
        $openConnection->isOpen()->willReturn(true);

        $closedConnection->beADoubleOf(Connection::class);
        $closedConnection->isOpen()->willReturn(false);

        $this->checkConnection($openConnection)->shouldReturn(true);
        $this->shouldThrow(ClosedConnectionException::class)->duringCheckConnection($closedConnection);
    }

    protected function setUpConnection($connection)
    {
        $connection->beADoubleOf(Connection::class);
        $connection->isOpen()->willReturn(true);
        $this->addConnection('test', $connection);

        return $connection;
    }
}
