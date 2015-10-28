<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 9 */

$smarty_dir='./smarty/';
$connectFile = './myDbConnect.ini';

require($smarty_dir.'/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check  = true;
$smarty->debugging      = false;
$smarty->template_dir   = $smarty_dir.'templates';
$smarty->compile_dir    = $smarty_dir.'templates_c';
$smarty->cache_dir      = $smarty_dir.'cache';
$smarty->config_dir     = $smarty_dir.'configs';

include 'functions.php';

$connectInfo = [];
if (file_exists($connectFile)) {
    $connectInfo = parse_ini_file($connectFile, true);    
}
else {
    echo 'Не удалось найти файл с параметрами подключения к БД - '.basename($connectFile);
    exit();
}
$server_name = isset($connectInfo['server_name'])   ? $connectInfo['server_name'] : '';
$user_name   = isset($connectInfo['user_name'])     ? $connectInfo['user_name']   : '';
$password    = isset($connectInfo['password'])      ? $connectInfo['password']    : '';
$database    = isset($connectInfo['database'])      ? $connectInfo['database']    : '';

$db = new mysqli($server_name, $user_name, $password, $database);
if($db->connect_errno > 0){
    die('Не удалось установить соединение с БД ['. $db->connect_error.']');
}
$db->query('SET NAMES UTF8');        

$cities     = getCitiesFromDb($db);
$categories = getCategoriesFromDb($db);
$adList     = getAdListFromDb($db);

$showAd = ''; 

if (isset($_POST['submit'])) {
    $data = fillData($_POST);
    if (checkForm($data)) {        
        if (isset($data['show_id'])) {
            $id = $data['show_id'];
            unset($data['show_id']);
            $result = updateAdInDb($db, $id, $data);            
        } else {
            $result = insertAdIntoDb($db, $data);
        }    
        if($result) {
            header("Location: ./index.php");                    
        }        
    } else {
        $showAd = $_POST;
    }    
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showAd = getAdFromDb($db, $id);    
    $showAd['show_id'] = $_GET['id'];    
} elseif (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];
    deleteAdFromDb ($db, $del_id);    
    header("Location: ./index.php");
}
   
$data = fillData($showAd);

$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->assign('adList', $adList);

$smarty->display('index.tpl');