<?php

require_once './DbSimple/config.php';
require_once './DbSimple/DbSimple/Generic.php';
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
    
    function getCategories() {
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
    
    function getAdList() {
        return $this->adList;
    }    
    
    /* Проверка заполнения всех параметров формы */
    private function checkForm($ad) {
        $errorList = array();
        if ($ad->seller_name == '') {
            $errorList[] = 'Укажите Ваше имя';
        }
        if ($ad->title == '') {
            $errorList[] = 'Укажите название объявления';
        }
        if (!is_numeric($ad->price)) {
            $errorList[] = 'Цену нужно указывать цифрами';
        }
        if (count($errorList)) {
            echo "<br/><b>Не все поля заполнены:</b><br/>";
            foreach ($errorList as $value) {
                echo $value . "<br/>";
            }
            echo "<br/>";
            return false;
        }
        return true;
    }
    
    /* Поиск объявления в списке */
    private function findAdInList($id) {
        $ad = null;        
        foreach ($this->adList['ads'] as $key => $value) {
            if($value->id == $id) {                
                $ad = $this->adList['ads'][$key];                
                break;
            }            
        }         
        return $ad;
    }
    
    /* Обработчик формы */
    public function handleForm ($post, $get) {       
        $showAd = null; 
        
        if (isset($post['submit'])) {                
            $ad = new Ad($post);            
            if ($this->checkForm($ad)) {        
                if (isset($ad->show_id)) {
                    $id = $ad->show_id;
                    $ad->setId($id);
                    $ad->setShowId('');    
                    $ad->updateAdInDb($this->dbConnection);                                        
                } 
                else {
                    $ad->saveAdInDb($this->dbConnection);
                }  
                header("Location: ./index.php");
            } 
            else {               
                $showAd = $ad;
            }    
        } elseif (isset($get['id'])) {
            $id = $get['id'];
            $showAd = $this->findAdInList($id);                        
            if (!is_null($showAd)) {
                $showAd->setShowId($id);    
            }
        } elseif (isset($get['del_id'])) {
            $del_id = $get['del_id'];
            $ad = $this->findAdInList($del_id);
            if (!is_null($ad)) {
                $ad->deleteAdFromDb($this->dbConnection);
            }
            header("Location: ./index.php");
        }
        
        if (is_null($showAd)) {
            $showAd = new Ad();
        }
        return $showAd;
    }
}