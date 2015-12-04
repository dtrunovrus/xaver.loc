<?php
error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 11 */

require_once './AdsManager.php';

$smarty_dir='./smarty/';
require($smarty_dir.'/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check  = true;
$smarty->debugging      = false;
$smarty->template_dir   = $smarty_dir.'templates';
$smarty->compile_dir    = $smarty_dir.'templates_c';
$smarty->cache_dir      = $smarty_dir.'cache';
$smarty->config_dir     = $smarty_dir.'configs';

$obj = new AdsManager();
$data = $obj->handleForm($_POST, $_GET);

$cities     = $obj->getCities();
$categories = $obj->getCategories();
$adList     = $obj->getAdList(); 

$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->assign('adList', $adList);

$smarty->display('index.tpl');

?>