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

include 'functions.php';

$obj = new AdsManager();

$dbConnection   = $obj->getDbConnection();
$cities         = $obj->getCities();
$categories     = $obj->getCategories();
$adList         = $obj->getAdList(); 

$showAd = ''; 

if (isset($_POST['submit'])) {                
    $ad = new Ad($_POST);            
    if ($ad->checkForm()) {        
        if ((isset($ad->show_id)) && ($ad->show_id!='')) {
            $id = $ad->show_id;
            $ad->setId($id);
            $ad->setShowId('');    
            $ad->updateAdInDb($dbConnection);                                        
        } 
        else {
            $ad->saveAdInDb($dbConnection);
        }  
        header("Location: ./index.php");
    } 
    else {               
        $showAd = $ad;
    }    
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showAd = $obj->findAdInList($id);                        
    if (!is_null($showAd)) {
        $showAd->setShowId($id);    
    }
} elseif (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];
    $ad = $obj->findAdInList($del_id);
    if (!is_null($ad)) {
        $ad->deleteAdFromDb($dbConnection);
    }
    header("Location: ./index.php");
}

if (is_null($showAd)) {
    $showAd = new Ad();
}
    
$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('data', $showAd);
$smarty->assign('adList', $adList);

$smarty->display('index.tpl');

?>