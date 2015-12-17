<?php

class CompanyAd extends Ad {
    public function __construct($data=NULL) {
        if (!is_null($data))
        {
            parent::__construct($data);            
        }
    }
}

?>