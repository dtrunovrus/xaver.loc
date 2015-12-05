<?php

require_once './DbSimple/config.php';
require_once './DbSimple/DbSimple/Generic.php';
require_once './functions.php';
require_once './Ad.php';

class AdsManager {
    private $dbConnection;
    private $connectFile    = './myDbConnect.ini';
    private $cities; 
    private $categories;
    private $adList;
    
    public function __construct() {
        $this->setDbConnection();
        $this->dbConnection->query('SET NAMES UTF8');              
        
        $this->setCities();
        $this->setCategories();
        $this->setAdList();
    }    
    
    private function setDbConnection() {
        $connectInfo = [];
        if (file_exists($this->connectFile)) {
            $connectInfo = parse_ini_file($this->connectFile, true);    
        }
        else {
            echo 'Не удалось найти файл с параметрами подключения к БД - '.basename($connectFile);
            exit();
        }
        $server_name = isset($connectInfo['server_name'])   ? $connectInfo['server_name'] : '';
        $user_name   = isset($connectInfo['user_name'])     ? $connectInfo['user_name']   : '';
        $password    = isset($connectInfo['password'])      ? $connectInfo['password']    : '';
        $database    = isset($connectInfo['database'])      ? $connectInfo['database']    : '';

        $this->dbConnection = DbSimple_Generic::connect("mysqli://$user_name:$password@$server_name/$database");        
        $this->dbConnection->setErrorHandler('databaseErrorHandler');
        $this->dbConnection->setLogger('myLogger');
    }
    
    public function getDbConnection() {
        return $this->dbConnection;
    }    
        
    /* Установка справочника городов из БД */
    private function setCities() {
        $dbCities = [];
        $result = $this->dbConnection->select('select * from cities order by name');    
        foreach ($result as $key => $row) {
            $id     = $row['id'];
            $name   = $row['name'];
            $dbCities[$id] = $name;
        }
        $this->cities = $dbCities;
    }
        
    public function getCities() {
        return $this->cities;
    }    

    /* Установка справочника категорий из БД */
    private function setCategories() {
        $dbCategories = [];
        $result = $this->dbConnection->select('select grp.name grp_name,
                                                      cat.id cat_id,
                                                      cat.name cat_name
                                                 from categories cat, category_groups grp
                                                where cat.groupid = grp.id');    
        foreach ($result as $key => $row) {
            $grp_name   = $row['grp_name'];
            $cat_id     = $row['cat_id'];
            $cat_name   = $row['cat_name'];
            $dbCategories[$grp_name][$cat_id] = $cat_name;
        }
        $this->categories =  $dbCategories;
    }
    
    public function getCategories() {
        return $this->categories;
    }    

    /* Установка списка объявлений из БД */
    private function setAdList() {
        $dbAdList = [];
        $result = $this->dbConnection->select('select * from ads');
        foreach ($result as $key => $row) {
            $ad = new Ad($row);
            $dbAdList['ads'][] = $ad;
        }
        $this->adList = $dbAdList;
    }
    
    public function getAdList() {
        return $this->adList;
    }    
       
    /* Поиск объявления в списке */
    public function findAdInList($id) {
        $ad = null;        
        foreach ($this->adList['ads'] as $key => $value) {
            if($value->id == $id) {                
                $ad = $this->adList['ads'][$key];                
                break;
            }            
        }         
        return $ad;
    }     
}