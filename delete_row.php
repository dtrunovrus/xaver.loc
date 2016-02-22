<?php

require_once 'ConnectionManager.php';
$connectionManager = ConnectionManager::instance();
$dbConnection = $connectionManager->getDbConnection(); 

switch ($_GET['action']) {
    case 'delete':
        if ($dbConnection->query('DELETE FROM ads WHERE id = ?d', $_GET['id'])) {
            $result['status'] = 'success';
            $result['message'] = 'Ad №'.$_GET['id'].' was removed successfully';
        }
        else {
            $result['status'] = 'error';
            $result['message'] = 'Remove failed';
        }
        echo json_encode($result);
            
        break;
        
    default:
        break;
}
?>