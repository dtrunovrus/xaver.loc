<?php
error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 11 */
require_once 'functions.php';

$dbSimple_dir = './DbSimple/';
require_once $dbSimple_dir.'config.php';
require_once $dbSimple_dir.'DbSimple/Generic.php';

$smarty_dir='./smarty/';
require $smarty_dir.'/libs/Smarty.class.php';

$smarty = new Smarty();
$smarty->compile_check  = true;
$smarty->debugging      = false;
$smarty->template_dir   = $smarty_dir.'templates';
$smarty->compile_dir    = $smarty_dir.'templates_c';
$smarty->cache_dir      = $smarty_dir.'cache';
$smarty->config_dir     = $smarty_dir.'configs';

$dumpFile       = './test.sql';
$server_name    = 'localhost';
$user_name      = 'test';
$password       = '123';
$database       = 'test';

if (isset($_POST['install_submit'])) {   
    $server_name = isset($_POST['server_name']) ? $_POST['server_name'] : '';
    $user_name   = isset($_POST['user_name'])   ? $_POST['user_name']   : '';
    $password    = isset($_POST['password'])    ? $_POST['password']    : '';
    $database    = isset($_POST['database'])    ? $_POST['database']    : '';
    if ($server_name=='' || $user_name=='' || $password == '' || $database == '') {
        Echo 'Не все поля заполнены! </br>';
    }
    else {
        $db = DbSimple_Generic::connect("mysqli://$user_name:$password@$server_name/$database");                
        $db->setErrorHandler('databaseErrorHandler');
        $db->setLogger('myLogger');
        
        $db->query('SET NAMES UTF8'); 
        $db->query('DROP TABLE IF EXISTS ads, categories, category_groups, cities');   
        
        $command = 'mysql -h' .$server_name .' -u' .$user_name .' -p' .$password .' ' .$database .' < ' .$dumpFile;
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

$connectStr =   "server_name = $server_name;\n".
                "user_name   = $user_name;  \n".
                "password    = $password;   \n".
                "database    = $database;   \n";
$connectFile = './myDbConnect.ini';
file_put_contents($connectFile, $connectStr);
       
$smarty->assign('server_name', $server_name);
$smarty->assign('user_name', $user_name);
$smarty->assign('password', $password);
$smarty->assign('database', $database);
$smarty->display('install.tpl');

?>