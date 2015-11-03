<?php

require_once './FirePhpCore/FirePHP.class.php';

/* Заполнение $data данными из массива */

function fillData($ad = '') {
    $data['physical']       = ($ad) ? $ad['physical']       : 1;
    $data['seller_name']    = ($ad) ? $ad['seller_name']    : '';
    $data['email']          = ($ad) ? $ad['email']          : '';
    $data['title']          = ($ad) ? $ad['title']          : '';
    $data['phone']          = ($ad) ? $ad['phone']          : '';
    $data['description']    = ($ad) ? $ad['description']    : '';
    $data['price']          = ($ad) ? $ad['price']          : 0;
    $data['id']             = ($ad && isset($ad['id']))             ? $ad['id']             : 0;
    $data['allow_mails']    = ($ad && isset($ad['allow_mails']))    ? $ad['allow_mails']    : 0;
    $data['city']           = ($ad && isset($ad['city']))           ? $ad['city']           : '';
    $data['category']       = ($ad && isset($ad['category']))       ? $ad['category']       : '';
    if ($ad && isset($ad['show_id']) && $ad['show_id'] != '') {
        $data['show_id'] = $ad['show_id'];
    }
    return $data;
}

/* Проверка заполнения всех параметров формы */

function checkForm($data) {
    $errorList = array();
    if ($data['seller_name'] == '') {
        $errorList[] = 'Укажите Ваше имя';
    }
    if ($data['title'] == '') {
        $errorList[] = 'Укажите название объявления';
    }
    if (!is_numeric($data['price'])) {
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

/* Получение справочника городов из БД */

function getCitiesFromDb($db) {
    $dbCities = [];
    $result = $db->select('select * from cities order by name');    
    foreach ($result as $key => $row) {
        $id     = $row['id'];
        $name   = $row['name'];
        $dbCities[$id] = $name;
    }
    return $dbCities;
}

/* Получение справочника категорий из БД */

function getCategoriesFromDb($db) {
    $dbCategories = [];
    $result = $db->select('select grp.name grp_name,
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
    return $dbCategories;
}

/* Получение списка объявлений из БД */

function getAdListFromDb($db) {
    $dbAdList = [];
    $result = $db->select('select * from ads');
    foreach ($result as $key => $row) {
        $data = fillData($row);
        $dbAdList['ads'][] = $data;
    }
    return $dbAdList;
}

/* Получение конкретного объявления из БД */

function getAdFromDb($db, $adId) {
    $dbData = [];
    if (is_numeric($adId) && $adId > 0) {
        $dbData = $db->selectRow('select * from ads where ads.id = ?d', $adId);
    }
    return $dbData;
}

/* Запись нового объявления в БД */

function insertAdIntoDb($db, $data) {
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
                                        $data['physical'], 
                                        $data['seller_name'], 
                                        $data['email'], 
                                        $data['title'], 
                                        $data['phone'], 
                                        $data['description'], 
                                        $data['price'], 
                                        $data['allow_mails'], 
                                        $data['city'], 
                                        $data['category']);    
    /*
    if (!$stmt) {
        echo "Ошибка записи в БД. </br>";
        return false;
    }
    return true;
    */
}

/* Обновление записи в БД */

function updateAdInDb($db, $adId, $data) {
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
                                $data['physical'], 
                                $data['seller_name'], 
                                $data['email'], 
                                $data['title'], 
                                $data['phone'], 
                                $data['description'], 
                                $data['price'], 
                                $data['allow_mails'], 
                                $data['city'], 
                                $data['category'], 
                                $adId);    
    /*
    if (!$stmt) {
        echo "Ошибка обновления записи в БД </br>";
        return false;
    }    
    return true;
    */
}

/* Удаление записи из БД */

function deleteAdFromDb($db, $adId) {
    $stmt = $db->query('DELETE FROM ads WHERE id = ?d',$adId);    
    /*
    if (!$stmt) {
        echo 'Ошибка удаления записи из БД ' . $stmt->errno . "</br>";
        return false;
    }
    return true;
    */
}

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info) {
    // Если использовалась @, ничего не делать.
    if (!error_reporting())
        return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>";
    print_r($info);
    echo "</pre>";
    exit();
}

function myLogger($db, $sql, $caller)
{  
  $firePHP = FirePHP::getInstance(true);
  $firePHP->setEnabled(true);

  if (isset($caller['file']))
  {
     $firePHP->group("at ".$caller['file'].' line '.$caller['line']);
     $firePHP->log($sql);
     $firePHP->groupEnd();
  }
}
?>