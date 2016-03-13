<?php

require_once 'setting.php';

$dumpFile       = './test.sql';

$server_name    = 'localhost';
$user_name      = 'test';
$password       = '123';
$database       = 'test';
/*
$server_name    = 'localhost';
$user_name      = 'dtrunovrus';
$password       = '';
$database       = 'c9';
*/
if (isset($_POST['install_submit'])) {   
    $server_name = isset($_POST['server_name']) ? $_POST['server_name'] : '';
    $user_name   = isset($_POST['user_name'])   ? $_POST['user_name']   : '';
    $password    = isset($_POST['password'])    ? $_POST['password']    : '';
    $database    = isset($_POST['database'])    ? $_POST['database']    : '';
    if ($server_name=='' || $user_name=='' || $database == '') {
        Echo 'Не все поля заполнены! </br>';
    }
    else {
        $connectStr =   "server_name = $server_name;\n".
                        "user_name   = $user_name;  \n".
                        "password    = $password;   \n".
                        "database    = $database;   \n";
        $connectFile = './myDbConnect.ini';
        file_put_contents($connectFile, $connectStr);
        
        $connectionManager = ConnectionManager::instance();
        $db = $connectionManager->getDbConnection();   
        
        $db->query('SET NAMES UTF8'); 
        $db->query('DROP TABLE IF EXISTS ads, categories, category_groups, cities');   
        
        $command = 'mysql -h' .$server_name .' -u' .$user_name .' -p' .$password .' ' .$database .' < ' .$dumpFile;
        /*$command = 'mysql -h' .$server_name .' -u' .$user_name .' ' .$database .' < ' .$dumpFile;*/
        
        $output = [];
        exec($command,$output,$worked);
        switch($worked){
            case 0:
                echo "Дамп базы данных успешно загружен: <a href= \"./index.php\"> перейти к работе с объявлениями</a></br></br>";
                break;
            case 1:
                echo 'Не удалось загрузить дамп БД '.mysql_error().'</br>';
                break;
        }     
    }       
}
       
$smarty->assign('server_name', $server_name);
$smarty->assign('user_name', $user_name);
$smarty->assign('password', $password);
$smarty->assign('database', $database);
$smarty->display('install.tpl');

?>