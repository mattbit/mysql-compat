<?php

class EscapeTest extends BridgeTestCase
{
    /** @dataProvider escapingProvider */
    public function testRealEscapeString($expected, $unescaped)
    {
        $this->assertEquals($expected, $this->bridge->realEscapeString($unescaped));
    }

    /** @dataProvider escapingProvider */
    public function testEscapeString($expected, $unescaped)
    {
        $this->assertEquals($expected, $this->bridge->escapeString($unescaped));
    }

    public function escapingProvider()
    {
        return [
            ["1\' or \'1\' = \'1", "1' or '1' = '1"],
            ["O\'Reilly Media", "O'Reilly Media"],
            ['New line\n', "New line\n"],
            ["\\\\\\'test\\\\test", "\'test\\test"],
        ];
    }
}
