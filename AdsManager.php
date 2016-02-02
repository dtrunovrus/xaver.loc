<?php

class AdsManager {    
    
    private $dbConnection;
    private $cities; 
    private $categories;
    private $adList = [];
    
    private static $instance = NULL;
    
    public function __construct() {
        global $dbConnection;
        $this->dbConnection = $dbConnection;
        $this->dbConnection->query('SET NAMES UTF8');              
        
        $this->setCities();
        $this->setCategories();
        $this->getAllAdsFromDb();
    }    
    
    public static function instance() {
        if(self::$instance == NULL){
            self::$instance = new AdsManager($dbConnection);
        }
        return self::$instance;
    }    
    
    /* Установка справочника городов из БД */
    private function setCities() {
        $dbCities = [];                
        $dbCities = $this->dbConnection->select('select id AS ARRAY_KEY, name from cities order by name');                    
        $this->cities = $dbCities;
    }
        
    public function getCities() {
        return $this->cities;
    }    

    /* Установка справочника категорий из БД */
    private function setCategories() {
        $dbCategories = [];        
        $dbCategories = $this->dbConnection->select('select grp.name as ARRAY_KEY_1,
                                                            cat.id as ARRAY_KEY_2,
                                                            cat.name cat_name
                                                       from categories cat, category_groups grp
                                                      where cat.groupid = grp.id');           
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