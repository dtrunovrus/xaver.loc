<?php

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
    $bdCities = [];
    $result = $db->query('select * from cities order by name');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $bdCities[$id] = $name;
        }
    }
    return $bdCities;
}

/* Получение справочника категорий из БД */

function getCategoriesFromDb($db) {
    $dbCategories = [];
    $result = $db->query('select grp.name grp_name,
                                    cat.id cat_id,
                                    cat.name cat_name
                               from categories cat, category_groups grp
                              where cat.groupid = grp.id');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $grp_name = $row['grp_name'];
            $cat_id = $row['cat_id'];
            $cat_name = $row['cat_name'];
            $dbCategories[$grp_name][$cat_id] = $cat_name;
        }
    }
    return $dbCategories;
}

/* Получение списка объявлений из БД */

function getAdListFromDb($db) {
    $dbAdList = [];
    $result = $db->query('select * from ads');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data = fillData($row);
            $dbAdList['ads'][] = $data;
        }
    }
    return $dbAdList;
}

/* Получение конкретного объявления из БД */

function getAdFromDb($db, $adId) {
    $dbData = [];
    if (is_numeric($adId) && $adId > 0) {
        $stmt = $db->prepare('select * from ads where ads.id = ?');
        $stmt->bind_param('i', $adId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $dbData = fillData($row);
        }
        $stmt->close();
    }
    return $dbData;
}

/* Запись нового объявления в БД */

function insertAdIntoDb($db, $data) {
    $stmt = $db->prepare('INSERT INTO ads(physical, 
                                                  seller_name, 
                                                  email, 
                                                  title, 
                                                  phone, 
                                                  description, 
                                                  price, 
                                                  allow_mails, 
                                                  city, 
                                                  category)
                          VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssssdiss', $data['physical'], $data['seller_name'], $data['email'], $data['title'], 
                      $data['phone'], $data['description'], $data['price'], $data['allow_mails'], $data['city'], $data['category']);
    if (!$stmt->execute()) {
        echo 'Ошибка записи в БД ' . $stmt->errno . "</br>";
        return false;
    }
    return true;
}

/* Обновление записи в БД */

function updateAdInDb($db, $adId, $data) {
    $stmt = $db->prepare('UPDATE ads' .
                         '   SET physical = ?,' .
                         '       seller_name = ?,' .
                         '       email = ?,' .
                         '       title = ?,' .
                         '       phone = ?,' .
                         '       description = ?,' .
                         '       price = ?,' .
                         '       allow_mails = ?,' .
                         '       city = ?,' .
                         '       category = ?' .
                         ' WHERE id = ?');
    $stmt->bind_param('isssssdissi', $data['physical'], $data['seller_name'], $data['email'], $data['title'], $data['phone'], 
                      $data['description'], $data['price'], $data['allow_mails'], $data['city'], $data['category'], $adId);
    if (!$stmt->execute()) {
        echo 'Ошибка обновления записи в БД ' . $stmt->errno . "</br>";
        return false;
    }
    return true;
}

/* Удаление записи из БД */

function deleteAdFromDb($db, $adId) {
    $stmt = $db->prepare('DELETE FROM ads WHERE id = ?');
    $stmt->bind_param('i', $adId);
    if (!$stmt->execute()) {
        echo 'Ошибка удаления записи из БД ' . $stmt->errno . "</br>";
        return false;
    }
    return true;
}

?>