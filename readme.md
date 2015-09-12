# Old mysql functions compatibility for PHP7

This library tries to provide backward compatibility with the deprecated `mysql_*` functions.

## Caveat

You really should not use this unless strictly needed: it's much better to refactor the existing code to use `PDO` and prepared statements directly or an ORM like [Eloquent](https://github.com/illuminate/database).

Although library provides an hackish replacement for `mysql_real_escape_string`, you ought to refactor your code to use prepared statements.

## Requirements

`PHP >= 7.0` with the `PDO` driver is required.

## To do

- Add tests

- [X] `mysql_​affected_​rows`
- [ ] `mysql_​client_​encoding`
- [X] `mysql_​close`
- [X] `mysql_​connect`
- [ ] `mysql_​create_​db`
- [ ] `mysql_​data_​seek`
- [ ] `mysql_​db_​name`
- [ ] `mysql_​db_​query`
- [ ] `mysql_​drop_​db`
- [ ] `mysql_​errno`
- [X] `mysql_​error`
- [ ] `mysql_​escape_​string`
- [X] `mysql_​fetch_​array`
- [X] `mysql_​fetch_​assoc`
- [ ] `mysql_​fetch_​field`
- [ ] `mysql_​fetch_​lengths`
- [X] `mysql_​fetch_​object`
- [ ] `mysql_​fetch_​row`
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
- [X] `mysql_​get_​server_​info`
- [ ] `mysql_​info`
- [ ] `mysql_​insert_​id`
- [ ] `mysql_​list_​dbs`
- [ ] `mysql_​list_​fields`
- [ ] `mysql_​list_​processes`
- [ ] `mysql_​list_​tables`
- [ ] `mysql_​num_​fields`
- [ ] `mysql_​num_​rows`
- [ ] `mysql_​pconnect`
- [ ] `mysql_​ping`
- [X] `mysql_​query`
- [X] `mysql_​real_​escape_​string`
- [X] `mysql_​result`
- [X] `mysql_​select_​db`
- [ ] `mysql_​set_​charset`
- [ ] `mysql_​stat`
- [ ] `mysql_​tablename`
- [ ] `mysql_​thread_​id`
- [ ] `mysql_​unbuffered_​query`