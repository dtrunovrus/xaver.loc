<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 6 */

include 'arrays.php';

/**
 * @param $session $_SESSION
 * @param $get $_GET
 * @return string
 */
function getAdById($session, $id) {
    $out = '';
    if(isset($id)){
        $out = isset($session['ads'][$id])? $session['ads'][$id] : '';
    }
    return $out;
}

/* Заполнение $data данными из массива */
function fillData($ad = '') {
    $data['private']        = ($ad) ? $ad['private']        : 1;
    $data['seller_name']    = ($ad) ? $ad['seller_name']    : '';
    $data['email']          = ($ad) ? $ad['email']          : '';    
    $data['title']          = ($ad) ? $ad['title']          : '';    
    $data['phone']          = ($ad) ? $ad['phone']          : '';
    $data['description']    = ($ad) ? $ad['description']    : '';
    $data['price']          = ($ad) ? $ad['price']          : 0;    
    $data['allow_mails']    = ($ad && isset($ad['allow_mails'])) ? $ad['allow_mails']   : 0;    
    $data['city']           = ($ad && isset($ad['city']))        ? $ad['city']          : '';
    $data['category']       = ($ad && isset($ad['category']))    ? $ad['category']      : ''; 
    if ($ad && isset($ad['data_id']) && $ad['data_id']!='') {
        $data['data_id'] = $ad['data_id'];
    }
    return $data;
}

/* Проверка заполнения всех параметров формы */
function checkForm($data) {        
    $errorList = array();
    if ($data['seller_name']=='') {
        $errorList[] = 'Укажите Ваше имя';
    }    
    if ($data['title']=='') {
        $errorList[] = 'Укажите название объявления';
    }
    if (!is_numeric($data['price'])) {
        $errorList[] = 'Цену нужно указывать цифрами';
    }
    if (count($errorList)) {
        echo "<br/><b>Не все поля заполнены:</b><br/>";
        foreach ($errorList as $value) {
            echo $value."<br/>";
        }
        echo "<br/>";
        return false;
    }
    return true;
}

session_start();
$showAd = '';

if (isset($_POST['submit'])) {
    $data = fillData($_POST);
    if (checkForm($data)) {
        if (isset($data['data_id'])) {
            $id = $data['data_id'];
            unset($data['data_id']);
            $_SESSION['ads'][$id] = $data;
        } else {
            $_SESSION['ads'][] = $data;
        }
        header("Location: ./");
    } else {
        $showAd = $_POST;
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showAd = getAdById($_SESSION, $id);
    $showAd['data_id'] = $_GET['id'];
} elseif (isset($_GET['del_id'])) {
    unset($_SESSION['ads'][$_GET['del_id']]);
    header("Location: ./");
}

$data = fillData($showAd);
require_once 'htmlBody.php';