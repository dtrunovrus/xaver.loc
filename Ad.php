<?php

class Ad {    
    private $seller_name     = '';
    private $email           = '';
    private $title           = ''; 
    private $phone           = '';
    private $description     = '';
    private $price           = 0;    
    private $allow_mails     = 0;
    private $city            = '';
    private $category        = '';  
    private $id              = '';    
    private $dbConnection;
    
    public function __construct($data=NULL) {
        
        global $dbConnection;
        $this->dbConnection = $dbConnection;        
        if (!is_null($data)) {
            $this->setData($data);            
        }
    }   
    
    public function setData($data) {        
        $this->seller_name    = ($data) && isset($data['seller_name']) ? $data['seller_name']    : '';
        $this->email          = ($data) && isset($data['email'])       ? $data['email']          : '';
        $this->title          = ($data) && isset($data['title'])       ? $data['title']          : '';
        $this->phone          = ($data) && isset($data['phone'])       ? $data['phone']          : '';
        $this->description    = ($data) && isset($data['description']) ? $data['description']    : '';
        $this->price          = ($data) && isset($data['price'])       ? $data['price']          : 0;        
        $this->allow_mails    = ($data) && isset($data['allow_mails']) ? $data['allow_mails']    : 0;
        $this->city           = ($data) && isset($data['city'])        ? $data['city']           : '';
        $this->category       = ($data) && isset($data['category'])    ? $data['category']       : '';        
        if (($data) && isset($data['id']) && $data['id'] != '') {
            $this->id = $data['id'];
        }
    }    

    public function insertAdInDb() {
        $args = get_object_vars($this);                
        unset($args['id']);                    
        unset($args['dbConnection']); 
        unset($args['displayClass']);            
        $stmt = $this->dbConnection->query('INSERT INTO ads(?#) VALUES (?a)', 
                            array_keys($args), array_values($args));    
        return $stmt;
    }
    
    public function updateAdInDb() {
        
        $args = get_object_vars($this); 
        $args['physical'] = isset($args['physical']) ? $args['physical'] : 0;
        unset($args['dbConnection']); 
        unset($args['displayClass']);            
        $stmt = $this->dbConnection->query('UPDATE ads SET ?a WHERE id=?', $args, $args['id']);    
        return $stmt;
    }
    
    public function deleteAdFromDb() {
        $stmt = $this->dbConnection->query('DELETE FROM ads WHERE id = ?d',$this->id);  
        return $stmt;
    }
    
    /* Проверка заполнения всех параметров формы */
    public function checkForm() {
        $errorList = array();
        if ($this->seller_name == '') {
            $errorList[] = 'Укажите Ваше имя';
        }
        if ($this->title == '') {
            $errorList[] = 'Укажите название объявления';
        }
        if (!is_numeric($this->price)) {
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
    
    public function getSeller_name() {
        return $this->seller_name;
    }
            
    public function getEmail() {
        return $this->email;
    }
            
    public function getTitle() {
        return $this->title;
    }
            
    public function getPhone() {
        return $this->phone;
    }
            
    public function getDescription() {
        return $this->description;
    }
            
    public function getPrice() {
        return $this->price;
    }
            
    public function getAllow_mails() {
        return $this->allow_mails;
    }
            
    public function getCity() {
        return $this->city;
    }
    
    public function getCategory() {
        return $this->category;
    }
    
    public function getId() {
        return $this->id;
    }    
}

?>
