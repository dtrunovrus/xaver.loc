<?php

require_once './functions.php';
require_once './connection.php';

switch ($_GET['action']) {
    case 'delete':
        $dbConnection->query('DELETE FROM ads WHERE id = ?d', $_GET['id']);
        break;
    default:
        break;
}
?>