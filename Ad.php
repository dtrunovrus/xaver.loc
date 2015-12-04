<?php

class Ad {
    public $physical;
    public $seller_name;
    public $email;
    public $title; 
    public $phone;
    public $description;
    public $price;
    public $id;
    public $allow_mails;
    public $city;
    public $category;  
    public $show_id;
    
    public function __construct($data = NULL) {
        if (is_null($data)) {
            $this->setData(NULL);    
        }
        else {
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
        $this->id             = ($data) && isset($data['id'])          ? $data['id']             : 0;
        $this->allow_mails    = ($data) && isset($data['allow_mails']) ? $data['allow_mails']    : 0;
        $this->city           = ($data) && isset($data['city'])        ? $data['city']           : '';
        $this->category       = ($data) && isset($data['category'])    ? $data['category']       : '';
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
        $stmt = $db->query('INSERT INTO ads(physical, 
                                            seller_name, 
                                            email, 
                                            title, 
                                            phone, 
                                            description, 
                                            price, 
                                            allow_mails, 
                                            city, 
                                            category)
                            VALUES (?d, ?, ?, ?, ?, ?, ?f, ?d, ?, ?)', 
                                            $this->physical, 
                                            $this->seller_name, 
                                            $this->email, 
                                            $this->title, 
                                            $this->phone, 
                                            $this->description, 
                                            $this->price, 
                                            $this->allow_mails, 
                                            $this->city, 
                                            $this->category); 
    }
    
    public function updateAdInDb($db) {
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
                                    $this->physical, 
                                    $this->seller_name, 
                                    $this->email, 
                                    $this->title, 
                                    $this->phone, 
                                    $this->description, 
                                    $this->price, 
                                    $this->allow_mails, 
                                    $this->city, 
                                    $this->category, 
                                    $this->id); 
    }
    
    public function deleteAdFromDb($db) {
        $stmt = $db->query('DELETE FROM ads WHERE id = ?d',$this->id);  
    }
}

?>
