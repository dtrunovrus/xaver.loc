<?php

class IndividualAd extends Ad {
    protected $physical = 1;
    
    public function __construct($data=NULL) {
        if (!is_null($data))
        {  
            parent::__construct($data);
        }        
    }   
    
    public function getPhysical() {
        return $this->physical;
    }
    
    public function setPhysical($arg) {
        $this->physical = $arg;
    }    
}

?>