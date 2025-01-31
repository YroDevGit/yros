<?php

//This is the database config, all database settings can be customize here...

$hostname = getenv("DB_HOST"); //hostname

$dbname = getenv("DATABASE"); //database name
$username = getenv("DB_USERNAME"); //username
$password = getenv("DB_PASSWORD"); //password


$db_driver = getenv("DB_DRIVER"); // We support Mysqli, PDO and PostgreSQL
/**
 * mysql = for mysql
 * mysqli = for mysql
 * pdo = for pdo
 * PostgreSQL = for PostgreSQL
 * postgres = for PostgreSQL
 * pgsql = for PostgreSQL
 * 
 */

/**
 * @YROS framework
 * this is a database configuration where you can set up your database.
 */


$dbConfig = [
    'host' => $hostname,
    'username' => $username,
    'password' => $password,
    'database' => $dbname,
    'charset' => 'utf8',
    'driver' => strtolower($db_driver)
];
?>