<?php

use Mattbit\MysqlCompat\Mysql;
use Mattbit\MysqlCompat\Result;
use Mattbit\MysqlCompat\Connection;
use Mattbit\MysqlCompat\MysqlConstants;

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows(Connection $linkIdentifier = null) {
        return Mysql::affectedRows($linkIdentifier);
    }
}

if (!function_exists('mysql_client_encoding')) {
    function mysql_client_encoding(Connection $linkIdentifier = null) {
        return Mysql::clientEncoding($linkIdentifier);
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close(Connection $linkIdentifier = null) {
        return Mysql::close($linkIdentifier);
    }
}

if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null, $newLink = false, $clientFlags = 0) {
        return Mysql::connect($server, $username, $password, $newLink, $clientFlags);
    }
}

if (!function_exists('mysql_create_db')) {
    function mysql_create_db($databaseName, Connection $linkIdentifier = null) {
        return Mysql::createDb($databaseName, $linkIdentifier);
    }
}

if (!function_exists('mysql_db_query')) {
    function mysql_db_query($database, $query, Connection $linkIdentifier = null) {
        return Mysql::dbQuery($database, $query, $linkIdentifier);
    }
}

if (!function_exists('mysql_errno')) {
    function mysql_errno(Connection $linkIdentifier = null) {
        return Mysql::errno($linkIdentifier);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error(Connection $linkIdentifier = null) {
        return Mysql::error($linkIdentifier);
    }
}

if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        return Mysql::escapeString($string);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array(Result $result, $resultType = MysqlConstants::FETCH_BOTH) {
        return Mysql::fetchArray($result, $resultType);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc(Result $result) {
        return Mysql::fetchAssoc($result);
    }
}

if (!function_exists('mysql_fetch_field')) {
    function mysql_fetch_field(Result $result, $fieldOffset = 0) {
        return Mysql::fetchField($result, $fieldOffset);
    }
}

if (!function_exists('mysql_fetch_lengths')) {
    function mysql_fetch_lengths(Result $result) {
        return Mysql::fetchLengths($result);
    }
}

if (!function_exists('mysql_fetch_object')) {
    function mysql_fetch_object(Result $result, $className = 'stdClass', array $params = []) {
        return Mysql::fetchObject($result, $className, $params);
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row(Result $result) {
        return Mysql::fetchRow($result);
    }
}

if (!function_exists('mysql_get_server_info')) {
    function mysql_get_server_info(Connection $linkIdentifier = null) {
        return Mysql::getServerInfo($linkIdentifier);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id(Connection $linkIdentifier = null) {
        return Mysql::insertId($linkIdentifier);
    }
}

if (!function_exists('mysql_list_tables')) {
    function mysql_list_tables($database, Connection $linkIdentifier = null) {
        return Mysql::listTables($database, $linkIdentifier);
    }
}

if (!function_exists('mysql_num_fields')) {
    function mysql_num_fields(Result $result) {
        return Mysql::numFields($result);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows(Result $result) {
        return Mysql::numRows($result);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, Connection $linkIdentifier = null) {
        return Mysql::query($query, $linkIdentifier);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($string, Connection $linkIdentifier = null) {
        return Mysql::realEscapeString($string, $linkIdentifier);
    }
}

if (!function_exists('mysql_result')) {
    function mysql_result(Result $result, $row, $field = 0) {
        return Mysql::result($result, $row, $field);
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($databaseName, Connection $linkIdentifier = null) {
        return Mysql::selectDb($databaseName, $linkIdentifier);
    }
}
