<?php

require_once 'settings.php';
$dbConnection   = ConnectionManager::instance();
$adsStore       = AdsManager::instance();

switch ($_GET['action']) {
    
    case 'insert':                     
        $ad = AdFactory::factory($_POST);
        $adId = $ad->getId();
        if ($adId==0) {
            $res = $ad->insertAdInDb();  
            if ($res) {        
                $adsStore->getAllAdsFromDb();
                $adList = $adsStore->getAdList();  
                $ad = $adList[$res];   
                $smarty->assign('ad',$ad);                
                $result['adInfo'] = $smarty->fetch('table_row.tpl.html');
                $result['status']='success';
                $result['message'] = "Ad ".$ad->getTitle()." has been inserted successfully";
            }
            else {
                $result['status']='error';
                $result['message'] = "Couldn't insert ad to database";
            }                
        }        
        else {
            $res = $ad->updateAdInDb();
            $adsStore->getAllAdsFromDb();
            $adList = $adsStore->getAdList();  
            if ($res>0) {                
                $ad = $adList[$adId];   
                $result['status']='success';
                $result['message'] = "Ad ".$ad->getTitle()." has been updated successfully";
            }
            else {
                $result['status']='error';
                $result['message'] = "Couldn't update ad in database";
            }                 
        } 
                
        break;
        
    case 'delete':
        $adList = $adsStore->getAdList();        
        $ad = $adList[$_GET['id']];        
        $res = $ad->deleteAdFromDb();
        if ($res) {
            $result['status'] = 'success';
            $result['message'] = 'Ad '.$ad->getTitle().' has been removed successfully';
        }
        else {
            $result['status'] = 'error';
            $result['message'] = 'Remove failed';
        }
        break;
        
    case 'edit':
        $adList = $adsStore->getAdList();        
        $ad = $adList[$_GET['id']];        
        $result['status'] = 'success';
        
        $result['physical'] = $ad instanceof IndividualAd ? 1 : 0;
        $result['seller_name'] = $ad->getSeller_name();
        $result['email'] = $ad->getEmail();
        $result['allow_mails'] = $ad->getAllow_mails();
        $result['phone'] = $ad->getPhone();
        $result['city'] = $ad->getCity();
        $result['category'] = $ad->getCategory();
        $result['title'] = $ad->getTitle();
        $result['description'] = $ad->getDescription();
        $result['price'] = $ad->getPrice();
        $result['id'] = $ad->getId();        
        //$result['ad'] = $ad;
        break;        
        
    default:
        break;
}

echo json_encode($result);

?>