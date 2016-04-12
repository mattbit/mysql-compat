<?php

namespace spec\Mattbit\MysqlCompat;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\ConnectionFactory');
    }
}
