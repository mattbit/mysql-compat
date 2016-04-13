<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

use Mattbit\MysqlCompat\Connection;

trait EscapeInput
{
    public function escapeString($unescapedString)
    {
        return $this->realEscapeString($unescapedString);
    }

    public function realEscapeString($unescapedString, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        $escaped = $connection->quote($unescapedString);
        // Hack!
        if ($escaped[0] === "'" && $escaped[strlen($escaped) - 1] === "'") {
            return substr($escaped, 1, -1);
        }

        throw new \Exception('Cannot escape string');
    }
}
