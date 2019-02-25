
# Old mysql functions compatibility for PHP5.6 and PHP7

[![Build Status](https://travis-ci.org/mattbit/mysql-compat.svg?branch=master)](https://travis-ci.org/mattbit/mysql-compat)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mattbit/mysql-compat/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mattbit/mysql-compat/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d9fcd340-4f29-46ac-966a-9df364b87aae/mini.png)](https://insight.sensiolabs.com/projects/d9fcd340-4f29-46ac-966a-9df364b87aae)

This library tries to provide backward compatibility with the deprecated `mysql_*` functions.

## Caveat

You really should not use this unless strictly needed: it's much better to refactor the existing code to use `PDO` and prepared statements directly or an ORM like [Eloquent](https://github.com/illuminate/database).

Although library provides an hackish replacement for `mysql_real_escape_string`, you ought to refactor your code to use prepared statements.

## Requirements

`PHP >= 5.6` with the `PDO` driver is required (`PHP 7` is supported).

## Installation

You can install `mysql-compat` via [composer](https://getcomposer.org/):

```
composer require mattbit/mysql-compat
```

## Usage

The `mysql_`-equivalent functions are available through the facade class `Mattbit\MysqlCompat\Mysql`.

```php
require __DIR__ . '/vendor/autoload.php';

use Mattbit\MysqlCompat\Mysql;

Mysql::connect('host', 'user', 'password');
Mysql::selectDb('my_db');

$result = Mysql::query('SELECT * FROM my_table');

$row = Mysql::fetchArray($result);
```

Note that the static methods are named in a camel-case like version of the original functions, e.g. `mysql_fetch_array` becomes `Mysql::fetchArray`.

If you are using PHP7 and want to re-define the old global functions and constants without touching existing code, you can use the `Mysql::defineGlobals` method:

```php
require __DIR__ . '/vendor/autoload.php';

Mattbit\MysqlCompat\Mysql::defineGlobals();

mysql_connect('host', 'user', 'password');
mysql_select_db('my_db');

$result = mysql_query('SELECT * FROM my_table');

$row = mysql_fetch_array($result, MYSQL_BOTH);
```

If you need to customize connection's DSN (eg.: to specify the charset) you can set it directly fetching the Manager and manually calling its `connect` method:

```php
require __DIR__ . '/vendor/autoload.php';

use Mattbit\MysqlCompat\Mysql;

$manager = Mysql::getManager();
$manager->connect('mysql:dbname=database;host=hostname;charset=customCharset', 'user', 'password');

$result = Mysql::query('SELECT * FROM my_table');

$row = Mysql::fetchArray($result);
```

## To do

- [X] `mysql_​affected_​rows`
- [ ] `mysql_​client_​encoding`
- [X] `mysql_​close`
- [X] `mysql_​connect`
- [ ] `mysql_​create_​db`
- [X] ~~mysql_​data_​seek~~ (not supported)
- [ ] `mysql_​db_​name`
- [ ] `mysql_​db_​query`
- [ ] `mysql_​drop_​db`
- [X] `mysql_​errno`
- [X] `mysql_​error`
- [X] `mysql_​escape_​string`
- [X] `mysql_​fetch_​array`
- [X] `mysql_​fetch_​assoc`
- [X] `mysql_​fetch_​field`
- [X] `mysql_​fetch_​lengths`
- [X] `mysql_​fetch_​object`
- [X] `mysql_​fetch_​row`
- [ ] `mysql_​field_​flags`
- [ ] `mysql_​field_​len`
- [ ] `mysql_​field_​name`
- [ ] `mysql_​field_​seek`
- [ ] `mysql_​field_​table`
- [ ] `mysql_​field_​type`
- [ ] `mysql_​free_​result`
- [ ] `mysql_​get_​client_​info`
- [ ] `mysql_​get_​host_​info`
- [ ] `mysql_​get_​proto_​info`
- [ ] `mysql_​get_​server_​info`
- [ ] `mysql_​info`
- [X] `mysql_​insert_​id`
- [ ] `mysql_​list_​dbs`
- [ ] `mysql_​list_​fields`
- [ ] `mysql_​list_​processes`
- [ ] `mysql_​list_​tables`
- [ ] `mysql_​num_​fields`
- [X] `mysql_​num_​rows`
- [ ] `mysql_​pconnect`
- [ ] `mysql_​ping`
- [X] `mysql_​query`
- [X] `mysql_​real_​escape_​string`
- [ ] `mysql_​result`
- [ ] `mysql_​select_​db`
- [ ] `mysql_​set_​charset`
- [ ] `mysql_​stat`
- [ ] `mysql_​tablename`
- [ ] `mysql_​thread_​id`
- [ ] `mysql_​unbuffered_​query`
