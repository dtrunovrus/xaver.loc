<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 6 */

include 'arrays.php';
include 'fucntions.php';

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

var_dump($_SESSION);