<?php

global $dbConnection;

switch ($_GET['action']) {
    case 'delete':
        $dbConnection->query('DELETE FROM ads WHERE id = ?d', $_GET['id']);
        break;
    default:
        break;
}
?>