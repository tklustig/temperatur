<?php

define('prefix', 'k158364_');
define('OPS', 'WINNT');
if (PHP_OS == OPS) {
    $username = 'root';
    $server = 'localhost';
    $password = '';
    $database = 'createrecords';
    //DatenbankErzeugen($dsn, $username, $password);
    //dieser else-Zweig kann dekommentiert werden, sofern auch für LINUX eine Datenbank angelegt werden soll. Dazu werden allerdings die Parameter benötigt
} else {
    $username = "k158364_kipp"; //für LINUX muss hier der Benutzer...
    $server = 'mysql2efb.netcup.net';
    $password = "1918Rott$"; //und hier das Passwort angegegeben werden
    $database = prefix . 'tklustig';
    //DatenbankErzeugen($dsn, $username, $password);
}
require_once 'inc/autoloader.php';
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass($username, $password, 'mysql', $server, $database);

