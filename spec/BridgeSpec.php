<?php

namespace spec\Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Bridge;
use Mattbit\MysqlCompat\Exception\NotSupportedException;
use Mattbit\MysqlCompat\Manager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BridgeSpec extends ObjectBehavior
{
    function let(Manager $manager)
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Bridge');
    }

    function it_throws_an_exception_with_unsupported_flags()
    {
        $this->shouldThrow(NotSupportedException::class)
             ->duringConnect('server', 'username', 'password', false, Bridge::CLIENT_INTERACTIVE);

        $this->shouldThrow(NotSupportedException::class)
            ->duringConnect('server', 'username', 'password', false, Bridge::CLIENT_SSL);

        $this->shouldThrow(NotSupportedException::class)
            ->duringConnect('server', 'username', 'password', false, Bridge::CLIENT_COMPRESS | Bridge::CLIENT_SSL);
    }
}
