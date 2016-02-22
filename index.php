<?php

error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 16 */
require_once './functions.php';

spl_autoload_register('autoLoadClasses');

$smarty_dir = './smarty/';
require($smarty_dir . '/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;
$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

$connectionManager = ConnectionManager::instance();
$dbConnection = $connectionManager->getDbConnection(); 
$adsStore = AdsManager::instance();
  
$adList = $adsStore->getAdList();

$showAd = NULL;

if (isset($_POST['submit'])) {
    $ad = AdFactory::factory($_POST);
    if ($ad->checkForm()) {
        $ad->saveAdInDb();
    } else {
        $showAd = $ad;
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showAd = $adList[$id];
}

if (is_null($showAd)) {
    $showAd = new Ad();
}
$smarty->assign('data', $showAd);

$adsStore->getAllAdsFromDb()->prepareForOut()->display();
?>