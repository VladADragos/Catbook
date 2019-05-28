<?php

define("HOST", 'localhost');
define("USER", 'root');
define("PASSWORD", '1234');
define("DBNAME", 'catbook');

$dsn = 'mysql:host=' . HOST . ';dbname=' . DBNAME;

function connect()
{
    global $dsn;
    $connection = new PDO($dsn, USER, PASSWORD);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $connection->setAttribute(PDO::FETCH_OBJ, PDO::ATTR_ERRMODE);
    return $connection;

};
