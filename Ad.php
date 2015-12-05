<?php

class Ad {
    public $physical        = 1;
    public $seller_name     = '';
    public $email           = '';
    public $title           = ''; 
    public $phone           = '';
    public $description     = '';
    public $price           = 0;    
    public $allow_mails     = 0;
    public $city            = '';
    public $category        = '';  
    public $id              = 0;
    public $show_id         = '';
    
    public function __construct($data=NULL) {
        if (!is_null($data)) {
            $this->setData($data);            
        }
    }   
    
    public function setData($data) {
        $this->physical       = ($data) && isset($data['physical'])    ? $data['physical']       : 1;
        $this->seller_name    = ($data) && isset($data['seller_name']) ? $data['seller_name']    : '';
        $this->email          = ($data) && isset($data['email'])       ? $data['email']          : '';
        $this->title          = ($data) && isset($data['title'])       ? $data['title']          : '';
        $this->phone          = ($data) && isset($data['phone'])       ? $data['phone']          : '';
        $this->description    = ($data) && isset($data['description']) ? $data['description']    : '';
        $this->price          = ($data) && isset($data['price'])       ? $data['price']          : 0;        
        $this->allow_mails    = ($data) && isset($data['allow_mails']) ? $data['allow_mails']    : 0;
        $this->city           = ($data) && isset($data['city'])        ? $data['city']           : '';
        $this->category       = ($data) && isset($data['category'])    ? $data['category']       : '';
        $this->id             = ($data) && isset($data['id'])          ? $data['id']             : 0;
        if (($data) && isset($data['show_id']) && $data['show_id'] != '') {
            $this->show_id = $data['show_id'];
        }
    }    
    
     public function setId ($id) {
        if (isset($id)) {
            $this->id = $id;
        }    
    }  
  
    public function setShowId ($id) {
        if (isset($id)) {
            $this->show_id = $id;
        }    
    }   
                    
    public function saveAdInDb($db) {
        $args = get_object_vars($this);
        unset($args['id']);
        unset($args['show_id']);
        $stmt = $db->query('INSERT INTO ads(?#) VALUES (?a)', 
                            array_keys($args), array_values($args));
    }
    
    public function updateAdInDb($db) {
        $args = get_object_vars($this);              
        $stmt = $db->query( 'UPDATE ads' .
                            '   SET physical = ?d,' .
                            '       seller_name = ?,' .
                            '       email = ?,' .
                            '       title = ?,' .
                            '       phone = ?,' .
                            '       description = ?,' .
                            '       price = ?f,' .
                            '       allow_mails = ?d,' .
                            '       city = ?,' .
                            '       category = ?' .
                            ' WHERE id = ?d',
                                    $args['physical'], 
                                    $args['seller_name'], 
                                    $args['email'], 
                                    $args['title'], 
                                    $args['phone'], 
                                    $args['description'], 
                                    $args['price'], 
                                    $args['allow_mails'], 
                                    $args['city'], 
                                    $args['category'], 
                                    $args['id']); 
    }
    
    public function deleteAdFromDb($db) {
        $stmt = $db->query('DELETE FROM ads WHERE id = ?d',$this->id);  
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
}

?>
