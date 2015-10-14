<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 8 */
$project_root=$_SERVER['DOCUMENT_ROOT'];
$smarty_dir=$project_root.'/smarty/';

require($smarty_dir.'/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->compile_check  = true;
$smarty->debugging      = false;
$smarty->template_dir   = $smarty_dir.'templates';
$smarty->compile_dir    = $smarty_dir.'templates_c';
$smarty->cache_dir      = $smarty_dir.'cache';
$smarty->config_dir     = $smarty_dir.'configs';

include 'arrays.php';
include 'fucntions.php';

$showAd = '';
$fileName = 'adList.txt';
$adList = getAdListFromFile($fileName);

if (isset($_POST['submit'])) {
    $data = fillData($_POST);
    if (checkForm($data)) {        
        if (isset($data['data_id'])) {
            $id = $data['data_id'];
            unset($data['data_id']);
            $adList['ads'][$id] = $data;
        } else {
            $adList['ads'][] = $data;
        }        
        header("Location: ./");
    } else {
        $showAd = $_POST;
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showAd = getAdById($adList, $id);
    $showAd['data_id'] = $_GET['id'];
} elseif (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];
    unset($adList['ads'][$del_id]);
    header("Location: ./");
}

if (file_put_contents($fileName, serialize($adList))===false) {
    echo "Ошибка записи в файл. <br>";
}        
$data = fillData($showAd);

$smarty->assign('project_root', $project_root);
$smarty->assign('cities', $cities);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->assign('adList', $adList);

$smarty->display('index.tpl');