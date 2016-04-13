<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

trait ManageErrors
{
    /**
     * Return the last error number. A value of 0 means no errors.
     *
     * @param Connection|null $linkIdentifier
     * @return int
     */
    public function errno(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return (int) $connection->getErrorInfo()[1];
    }

    /**
     * Return the last error text.
     *
     * @param Connection|null $linkIdentifier
     * @return string
     */
    public function error(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getErrorInfo()[2];
    }
}
