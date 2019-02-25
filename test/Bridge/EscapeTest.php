<?php

class EscapeTest extends BridgeTestCase
{
    /** @dataProvider escapingProvider */
    public function testRealEscapeString($expected, $unescaped)
    {
        $this->assertEquals(
            $expected,
            $this->bridge->realEscapeString($unescaped)
        );
    }

    /** @dataProvider escapingProvider */
    public function testEscapeString($expected, $unescaped)
    {
        $this->assertEquals(
            $expected,
            $this->bridge->escapeString($unescaped)
        );
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

    /**
     * @see https://github.com/mattbit/mysql-compat/pull/7#issuecomment-466809679
     */
    public function testEscapeWithCharset()
    {
        $nastyString = "\xbf\x27";

        $this->assertEquals(
            "\xbf\\\x27",
            $this->bridge->escapeString($nastyString)
        );

        // New connection with different charset.
        $dbname = $this->config['dbname'];
        $dbhost = $this->config['dbhost'];
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];
        $dsn = "mysql:dbname=$dbname;host=$dbhost;charset=gbk";

        $connection = $this->manager->connect($dsn, $dbuser, $dbpass);

        $this->assertEquals(
            "\\\xbf\\\x27",
            $this->bridge->escapeString($nastyString, $connection)
        );
    }
}
