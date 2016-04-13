<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\BridgeComponents\EscapeInput;
use Mattbit\MysqlCompat\BridgeComponents\ProvideInfo;
use Mattbit\MysqlCompat\BridgeComponents\FetchResults;
use Mattbit\MysqlCompat\BridgeComponents\ManageErrors;
use Mattbit\MysqlCompat\BridgeComponents\ManageFields;
use Mattbit\MysqlCompat\BridgeComponents\ManageResult;
use Mattbit\MysqlCompat\BridgeComponents\ManagesFields;
use Mattbit\MysqlCompat\BridgeComponents\ExecuteQueries;
use Mattbit\MysqlCompat\BridgeComponents\ManageConnections;

class Bridge
{
    /**
     * The database manager instance.
     *
     * @var Manager
     */
    protected $manager;

    use EscapeInput,
        ExecuteQueries,
        FetchResults,
        ManageConnections,
        ManageErrors,
        ManageFields,
        ManageResult,
        ProvideInfo;
    
    /**
     * Create a new bridge.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }
}
