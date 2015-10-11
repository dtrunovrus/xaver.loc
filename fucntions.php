<?php 
/**
 * @param $session $_SESSION
 * @param $get $_GET
 * @return string
 */
function getAdById($session, $id) {
    $out = '';
    if(isset($id)){
        $out = isset($session['ads'][$id])? $session['ads'][$id] : '';
    }
    return $out;
}

/* Заполнение $data данными из массива */
function fillData($ad = '') {
    $data['private']        = ($ad) ? $ad['private']        : 1;
    $data['seller_name']    = ($ad) ? $ad['seller_name']    : '';
    $data['email']          = ($ad) ? $ad['email']          : '';    
    $data['title']          = ($ad) ? $ad['title']          : '';    
    $data['phone']          = ($ad) ? $ad['phone']          : '';
    $data['description']    = ($ad) ? $ad['description']    : '';
    $data['price']          = ($ad) ? $ad['price']          : 0;    
    $data['allow_mails']    = ($ad && isset($ad['allow_mails'])) ? $ad['allow_mails'] : 0;    
    $data['city']           = ($ad && isset($ad['city']))        ? $ad['city']          : '';
    $data['category']       = ($ad && isset($ad['category']))    ? $ad['category']      : ''; 
    if ($ad && isset($ad['data_id']) && $ad['data_id']!='') {
        $data['data_id'] = $ad['data_id'];
    }
    return $data;
}

/* Проверка заполнения всех параметров формы */
function checkForm($data) {        
    $errorList = array();
    if ($data['seller_name']=='') {
        $errorList[] = 'Укажите Ваше имя';
    }    
    if ($data['title']=='') {
        $errorList[] = 'Укажите название объявления';
    }
    if (!is_numeric($data['price'])) {
        $errorList[] = 'Цену нужно указывать цифрами';
    }
    if (count($errorList)) {
        echo "<br/><b>Не все поля заполнены:</b><br/>";
        foreach ($errorList as $value) {
            echo $value."<br/>";
        }
        echo "<br/>";
        return false;
    }
    return true;
}
?>