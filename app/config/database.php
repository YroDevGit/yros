<?php

//This is the database config, all database settings can be customize here...

$hostname = "localhost"; //hostname

$dbname = ""; //database name
$username = "root"; //username
$password = ""; //password


$db_driver = "pdo"; // We support Mysql and PostgreSQL
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