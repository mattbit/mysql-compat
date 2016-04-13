<?php

namespace spec\Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\NotSupportedException;
use Mattbit\MysqlCompat\Manager;
use Mattbit\MysqlCompat\MysqlConstants;
use PhpSpec\ObjectBehavior;

class BridgeSpec extends ObjectBehavior
{
    public function let(Manager $manager)
    {
        $this->beConstructedWith($manager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Bridge');
    }

    public function it_throws_an_exception_with_unsupported_flags()
    {
        $this->shouldThrow(NotSupportedException::class)
             ->duringConnect('server', 'username', 'password', false, MysqlConstants::CLIENT_INTERACTIVE);

        $this->shouldThrow(NotSupportedException::class)
            ->duringConnect('server', 'username', 'password', false, MysqlConstants::CLIENT_SSL);

        $this->shouldThrow(NotSupportedException::class)
            ->duringConnect('server', 'username', 'password', false, MysqlConstants::CLIENT_COMPRESS | MysqlConstants::CLIENT_SSL);
    }
}
