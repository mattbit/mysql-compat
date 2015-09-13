<?php

namespace spec\Mattbit\MysqlCompat;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
