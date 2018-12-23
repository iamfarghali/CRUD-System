<?php
// Database Credentials
$host 		= 'localhost';
$dbName 	= 'crud_db';
$user 		= 'root';
$password 	= '';

$GLOBALS['dbConn'] = new PDO('mysql:host='.$host.';dbname='.$dbName, $user, $password);

$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbConn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>