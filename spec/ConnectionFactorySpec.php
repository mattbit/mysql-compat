<?php

namespace spec\Mattbit\MysqlCompat;

use PhpSpec\ObjectBehavior;

class ConnectionFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\ConnectionFactory');
    }
}
