<?php

namespace spec\Mattbit\MysqlCompat;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    protected $statement;

    function let($statement)
    {
        $statement->beADoubleOf('PDOStatement');
        $this->statement = $statement;
        $this->beConstructedWith($this->statement);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mattbit\MysqlCompat\Result');
    }
}
