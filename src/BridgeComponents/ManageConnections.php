<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

use PDO;
use Mattbit\MysqlCompat\Connection;
use Mattbit\MysqlCompat\MysqlConstants;
use Mattbit\MysqlCompat\Exception\NotSupportedException;

trait ManageConnections
{
    public function clientEncoding(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getCharset();
    }

    public function close(Connection $linkIdentifier = null)
    {
        return $this->manager->disconnect($linkIdentifier);
    }

    public function connect($server = null, $username = null, $password = null, $newLink = false, $clientFlags = 0)
    {
        if ($server   === null) {
            $server = ini_get('mysql.default_host');
        }
        if ($username === null) {
            $username = ini_get('mysql.default_user');
        }
        if ($password === null) {
            $password = ini_get('mysql.default_password');
        }

        $options = $this->parseClientFlags($clientFlags);

        return $this->manager->connect("mysql:host={$server};", $username, $password, $options, $newLink);
    }

    protected function parseClientFlags($clientFlags)
    {
        $options = [];

        if ($clientFlags & MysqlConstants::CLIENT_COMPRESS) {
            $options[PDO::MYSQL_ATTR_COMPRESS] = 1;
        }

        if ($clientFlags & MysqlConstants::CLIENT_IGNORE_SPACE) {
            $options[PDO::MYSQL_ATTR_IGNORE_SPACE] = 1;
        }

        if ($clientFlags & MysqlConstants::CLIENT_SSL) {
            throw new NotSupportedException('SSL is not supported. You must create the PDO instance manually.');
        }

        if ($clientFlags & MysqlConstants::CLIENT_INTERACTIVE) {
            throw new NotSupportedException('Interactive client is not supported by PDO.');
        }

        return $options;
    }

    public function pconnect()
    {
        // @todo
    }
}
