<?php

require_once './DbSimple/config.php';
require_once './DbSimple/DbSimple/Generic.php';
require_once './DbSimple/DbSimple/Mysqli.php';
require_once './functions.php';

class AdsManager {    
    private $connectFile = './myDbConnect.ini';
    private $dbConnection;
    private $cities; 
    private $categories;
    private $adList = [];
    
    private static $instance = NULL;
    
    public function __construct() {
        $this->setDbConnection();
        $this->dbConnection->query('SET NAMES UTF8');              
        
        $this->setCities();
        $this->setCategories();
        $this->getAllAdsFromDb();
    }    
    
    public static function instance() {
        if(self::$instance == NULL){
            self::$instance = new AdsManager();
        }
        return self::$instance;
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
       
    public function getAdList() {
        return $this->adList;
    }    
       
    public function addAds(Ad $ad) {
        if(!($this instanceof AdsManager)){
            die('Нельзя использовать этот метод в конструкторе классов');
        }
        $this->adList[$ad->getId()]=$ad;
    }
    
    public function delAds(Ad $ad) {
        if(!($this instanceof AdsManager)){
            die('Нельзя использовать этот метод в конструкторе классов');
        }
        unset($this->adList[$ad->getId()]);
    }
    
    public function getAllAdsFromDb() {        
        $all = $this->dbConnection->select('select * from ads');
        foreach ($all as $value){     
            if ($value['physical'] == 1) {
                $ad = new IndividualAd($value);
            } else {
                $ad = new CompanyAd($value);
            }            
            self::addAds($ad); //помещаем объекты в хранилище
        }
        return self::$instance;
    }
        
    public function findAdInList($id) {
        $ad = null;        
        foreach ($this->adList as $key => $value) {
            if($value->getId() == $id) {                
                $ad = $this->adList[$key];                
                break;
            }            
        }         
        return $ad;
    }     

    public function prepareForOut() {
        global $smarty;
        $row='';
        foreach ($this->adList as $value) {
            $smarty->assign('ad',$value);
            $row.=$smarty->fetch('table_row.tpl.html');
        }
        $smarty->assign('ads_rows',$row);
        return self::$instance;
    }
    
    public function display() {
        global $smarty;
        $smarty->assign('cities', $this->cities);
        $smarty->assign('categories', $this->categories);        
        $smarty->assign('adList', $this->adList);

        $smarty->display('index.tpl');
    }
    
}