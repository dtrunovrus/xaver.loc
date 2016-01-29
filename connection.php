<?php

require_once './DbSimple/config.php';
require_once './DbSimple/DbSimple/Generic.php';
require_once './DbSimple/DbSimple/Mysqli.php';
$connectFile = './myDbConnect.ini';
$connectInfo = [];

if (file_exists($connectFile)) {
    $connectInfo = parse_ini_file($connectFile, true);
} else {
    echo 'Не удалось найти файл с параметрами подключения к БД - ' . basename($connectFile);
    exit();
}
$server_name = isset($connectInfo['server_name']) ? $connectInfo['server_name'] : '';
$user_name = isset($connectInfo['user_name']) ? $connectInfo['user_name'] : '';
$password = isset($connectInfo['password']) ? $connectInfo['password'] : '';
$database = isset($connectInfo['database']) ? $connectInfo['database'] : '';

$dbConnection = (new DbSimple_Generic)->connect("mysqli://$user_name:$password@$server_name/$database");
$dbConnection->setErrorHandler('databaseErrorHandler');
$dbConnection->setLogger('myLogger');

?>