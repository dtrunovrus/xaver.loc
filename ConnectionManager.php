<?php

require_once './DbSimple/config.php';
require_once './DbSimple/DbSimple/Generic.php';
require_once './DbSimple/DbSimple/Mysqli.php';
require_once './functions.php';


class ConnectionManager {    
    
    private $connectFile = './myDbConnect.ini';
    private $connectInfo = [];
    private $dbConnection;
    
    private static $instance = NULL;
    
    public function __construct() {
        
        if (file_exists($this->connectFile)) {
            $this->connectInfo = parse_ini_file($this->connectFile, true);
        } else {
            echo 'Не удалось найти файл с параметрами подключения к БД - ' . basename($this->connectFile);
            exit();
        }
        
        $server_name    = isset($this->connectInfo['server_name'])  ? $this->connectInfo['server_name'] : '';
        $user_name      = isset($this->connectInfo['user_name'])    ? $this->connectInfo['user_name']   : '';
        $password       = isset($this->connectInfo['password'])     ? $this->connectInfo['password']    : '';
        $database       = isset($this->connectInfo['database'])     ? $this->connectInfo['database']    : '';

        $this->dbConnection = (new DbSimple_Generic)->connect("mysqli://$user_name:$password@$server_name/$database");
        $this->dbConnection->setErrorHandler('databaseErrorHandler');
        $this->dbConnection->setLogger('myLogger');
    }
   
    public static function instance() {
        if(self::$instance == NULL){
            self::$instance = new ConnectionManager();
        }
        return self::$instance;
    }  
    
    public function getDbConnection() {
        return $this->dbConnection;
    }
    
}

?>