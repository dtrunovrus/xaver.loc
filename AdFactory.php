<?php

class AdFactory {
    public static function factory($post){     
        $physical = isset($post['physical'])? $post['physical'] : 1;
        switch($physical) {
            case "0":
                $object = new CompanyAd($post);
            break;
            case "1":
                $object = new IndividualAd($post);               
            break;                
        default :
            $object = new Ad();
        }        
        return $object;
    }            
}

?>