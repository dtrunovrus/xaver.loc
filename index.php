<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 9 */

$smarty_dir='./smarty/';

require($smarty_dir.'/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check  = true;
$smarty->debugging      = false;
$smarty->template_dir   = $smarty_dir.'templates';
$smarty->compile_dir    = $smarty_dir.'templates_c';
$smarty->cache_dir      = $smarty_dir.'cache';
$smarty->config_dir     = $smarty_dir.'configs';

include 'fucntions.php';
session_start();
$server_name = isset($_SESSION['server_name']) ? $_SESSION['server_name'] : '';
$user_name   = isset($_SESSION['user_name'])   ? $_SESSION['user_name']   : '';
$password    = isset($_SESSION['password'])    ? $_SESSION['password']    : '';
$database    = isset($_SESSION['database'])    ? $_SESSION['database']    : '';

$db = mysql_connect($server_name, $user_name, $password) or die('Не удалось установить соединение с сервером БД '.mysql_error());

mysql_select_db('test', $db) or die('Не удалось выбрать БД '.mysql_error());
mysql_query('SET NAMES UTF8');

$cities = getCitiesFromDb($db);
$categories = getCategoriesFromDb($db);
$adList = getAdListFromDb($db);

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
            header("Location: ./");                    
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
    header("Location: ./");
}
   
$data = fillData($showAd);

$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->assign('adList', $adList);

$smarty->display('index.tpl');