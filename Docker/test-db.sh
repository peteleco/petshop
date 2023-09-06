#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS petshop_test;
    GRANT ALL PRIVILEGES ON \`petshop_test%\`.* TO '$MYSQL_USER'@'%';
EOSQL