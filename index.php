<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 6 */

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
    $data['allow_mails']    = ($ad && isset($ad['allow_mails'])) ? $ad['allow_mails']   : 0;    
    $data['city']           = ($ad && isset($ad['city']))        ? $ad['city']          : '';
    $data['category']       = ($ad && isset($ad['category']))    ? $ad['category']      : ''; 
    if ($ad && isset($ad['data_id']) && $ad['data_id']!='') {
        $data['data_id'] = $ad['data_id'];
    }
    return $data;
}

/* Вывод основной формы */
function showForm($data) {
    $cities = array('641780'=>'Новосибирск','641490'=>'Барабинск','641510'=>'Бердск',
                    '641600'=>'Искитим', '641630'=>'Колывань','641680'=>'Краснообск',
                    '641710'=>'Куйбышев','641760'=>'Мошково','641790'=>'Обь',
                    '641800'=>'Ордынское','641970'=>'Черепаново');
    $categories = array ('Транспорт'=>array('9'=>'Автомобили с пробегом',
                                            '109'=>'Новые автомобили',
                                            '14'=>'Мотоциклы и мототехника',
                                            '81'=>'Грузовики и спецтехника',
                                            '11'=>'Водный транспорт',
                                            '10'=>'Запчасти и аксессуары'),
                         'Недвижимость'=>array( '24'=>'Квартиры',
                                                '23'=>'Комнаты',
                                                '25'=>'Дома, дачи, коттеджи',
                                                '26'=>'Земельные участки',
                                                '85'=>'Гаражи и машиноместа',
                                                '42'=>'Коммерческая недвижимость',
                                                '86'=>'Недвижимость за рубежом'),
                         'Работа'=>array('111'=>'Вакансии (поиск сотрудников)',
                                         '112'=>'Резюме (поиск работы)'),        
                         'Услуги'=>array('114'=>'Предложения услуг',
                                         '115'=>'Запросы на услуги'),        
                         'Личные вещи'=>array ( '27'=>'Одежда, обувь, аксессуары',
                                                '29'=>'Детская одежда и обувь',     
                                                '30'=>'Товары для детей и игрушки',     
                                                '28'=>'Часы и украшения',     
                                                '88'=>'Красота и здоровье'),     
                         'Для дома и дачи'=>array ( '21'=>'Бытовая техника',
                                                    '20'=>'Мебель и интерьер',     
                                                    '87'=>'Посуда и товары для кухни',     
                                                    '82'=>'Продукты питания',     
                                                    '19'=>'Ремонт и строительство',     
                                                    '106'=>'Растения'),
                         'Бытовая электроника'=>array ( '32'=>'Аудио и видео',
                                                        '97'=>'Игры, приставки и программы',     
                                                        '31'=>'Настольные компьютеры',     
                                                        '98'=>'Ноутбуки',     
                                                        '99'=>'Оргтехника и расходники',     
                                                        '96'=>'Планшеты и электронные книги',
                                                        '84'=>'Телефоны',
                                                        '101'=>'Товары для компьютера',
                                                        '105'=>'Фототехника'),        
                         'Хобби и отдых'=>array('33'=>'Билеты и путешествия',
                                                '34'=>'Велосипеды',
                                                '83'=>'Книги и журналы',     
                                                '36'=>'Коллекционирование',     
                                                '38'=>'Музыкальные инструменты',     
                                                '102'=>'Охота и рыбалка',
                                                '39'=>'Спорт и отдых',
                                                '103'=>'Знакомства'),
                         'Животные'=>array( '89'=>'Собаки',
                                            '90'=>'Кошки',
                                            '91'=>'Птицы',     
                                            '92'=>'Аквариум',
                                            '93'=>'Другие животные',
                                            '94'=>'Товары для животных'),
                         'Для бизнеса'=>array ( '116'=>'Готовый бизнес',
                                                '40'=>'Оборудование для бизнеса')); 
    
    $cityIsChecked = ($data['city']=='')?false:true;
    $categoryIsChecked = ($data['category']=='')?false:true;
    include 'mainForm.php';
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

/* Вывод всех объявления в $_SESSION */
function showSessionList($session) {
    if (isset($session['ads']) && count($session['ads'])) {
        include 'sessionList.php';     
    }    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lesson 6</title>
        <style>
            .table1 {
                table-layout: fixed;        /* Фиксированная ширина ячеек */
                border-collapse: collapse;  /* Отображение рамки */
                width: 580px;               /* Ширина таблицы */    
            }
            .col1_1 { width: 180px; }      
            .col1_2 { width: 400px; }                  
            .table2 {
                table-layout: fixed;        /* Фиксированная ширина ячеек */
                border-collapse: collapse;  /* Отображение рамки */
                width: 800px;               /* Ширина таблицы */    
            }
            .col2_1 { width: 60px; }      
            .col2_2 { width: 30px; }      
            .col2_3 { width: 200px; }      
            .col2_4 { width: 35px; }      
        </style>
    </head>
    <body>
        <?php
        session_start();        
        $showAd = '';        
        
        if (isset($_POST['submit'])) {
            $data = fillData($_POST);
            if (checkForm($data)) {                                
                if(isset($data['data_id'])) {
                    $id = $data['data_id'];
                    unset($data['data_id']);
                    $_SESSION['ads'][$id] = $data;
                }
                else {
                    $_SESSION['ads'][] = $data;
                }                
                header("Location: ./");
            }
            else {
                $showAd = $_POST;
            }            
        }
        elseif (isset($_GET['id'])) {
            $id = $_GET['id'];
            $showAd = getAdById($_SESSION, $id);
            $showAd['data_id'] = $_GET['id'];
        }
        elseif (isset($_GET['del_id'])) {
            unset($_SESSION['ads'][$_GET['del_id']]);    
            header("Location: ./");
        }
        
        $data = fillData($showAd);
        showForm($data);
        showSessionList($_SESSION);
        ?>    
    </body>
</html>
