<?php declare(strict_types=1);

namespace {

    use Mattbit\MysqlCompat\Mysql;
    use Mattbit\MysqlCompat\Result;
    use Mattbit\MysqlCompat\Connection;

    if (!function_exists('mysql_connect')) {
        function mysql_connect(string $server = null, string $username = null , string $password = null, bool $new_link = false, int $client_flags = 0): Connection
        {
            $server   || $server = ini_get("mysql.default_host");
            $username || $username = ini_get("mysql.default_user");
            $password || $password = ini_get("mysql.default_password");

            return Mysql::connect("mysql:host={$server};", $username, $password);
        }
    }

    if (!function_exists('mysql_error')) {
        function mysql_error(): string
        {
            return '';
        }
    }

    if (!function_exists('mysql_close')) {
        function mysql_close(): bool
        {
            return Mysql::disconnect();
        }
    }

    if (!function_exists('mysql_get_server_info')) {
        function mysql_get_server_info(Connection $connection = null): string
        {
            if ($connection === null) {
                $connection = Mysql::getLastConnection();
            }

            return $connection->getServerInfo();
        }
    }

    if (!function_exists('mysql_select_db')) {
        function mysql_select_db(string $database_name, Connection $connection = null): bool
        {
            return Mysql::useDatabase($database_name, $connection);
        }
    }

    if (!function_exists('mysql_query')) {
        function mysql_query(string $query, Connection $connection = null)
        {
            return Mysql::query($query, $connection);
        }
    }

    if (!function_exists('mysql_free_result')) {
        function mysql_free_result(Result $result)
        {
            return $result->free();
        }
    }

    if (!function_exists('mysql_num_rows')) {
        function mysql_num_rows(Result $result)
        {
            return $result->count();
        }
    }

    if (!function_exists('mysql_result')) {
        function mysql_result(Result $result, int $row, $field = 0)
        {
            return $result->column($field, $row);
        }
    }

    if (!function_exists('mysql_fetch_array')) {
        function mysql_fetch_array(Result $result, int $result_type = Result::FETCH_BOTH)
        {
            return $result->fetch($result_type);
        }
    }

    if (!function_exists('mysql_fetch_assoc')) {
        function mysql_fetch_assoc(Result $result)
        {
            return $result->fetch(Result::FETCH_ASSOC);
        }
    }

    if (!function_exists('mysql_affected_rows')) {
        function mysql_affected_rows()
        {
            return $result->fetch(Result::FETCH_ASSOC);
        }
    }

    if (!function_exists('mysql_fetch_object')) {
        function mysql_fetch_object(Result $result, string $class_name = null, array $params = [])
        {
            return $result->fetchObject($class_name, $params);
        }
    }
    
    if (!function_exists('mysql_real_escape_string')) {
        function mysql_real_escape_string($unescaped_string, Connection $connection = null)
        {
            return Mysql::escape($unescaped_string, $connection);
        }
    }
}
