<?php

error_reporting(E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

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

?>
