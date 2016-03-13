<?php

require_once 'settings.php';

$dbConnection = ConnectionManager::instance();
$adsStore = AdsManager::instance();
  
$adList = $adsStore->getAdList();

$emptyAd = new Ad();
$smarty->assign('data', $emptyAd);

$adsStore->getAllAdsFromDb()->prepareForOut()->display();
?>