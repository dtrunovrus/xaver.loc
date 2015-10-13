<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 7 */
include 'arrays.php';
include 'fucntions.php';

session_start();
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
require_once 'htmlBody.php';

