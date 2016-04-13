<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

use PDO;
use Mattbit\MysqlCompat\Connection;

trait ProvideInfo
{
    public function getClientInfo()
    {
        // @todo
    }

    public function getHostInfo()
    {
        // @todo
    }

    public function getProtoInfo()
    {
        // @todo
    }

    public function getServerInfo(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function info()
    {
        // @todo
    }

    public function threadId()
    {
        // @todo
    }

    public function stat()
    {
        // @todo
    }

    public function ping()
    {
        // @todo
    }
}
