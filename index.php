<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 6 */

/* Заполнение $data данными из массива $_SESSION по id  */
function FillData($id = '') {
    $data['private']        = ($id!=='') ? $_SESSION['ads'][$id]['private']        : 1;
    $data['seller_name']    = ($id!=='') ? $_SESSION['ads'][$id]['seller_name']    : '';
    $data['email']          = ($id!=='') ? $_SESSION['ads'][$id]['email']          : '';
    $data['allow_mails']    = ($id!=='') ? $_SESSION['ads'][$id]['allow_mails']    : 0;
    $data['phone']          = ($id!=='') ? $_SESSION['ads'][$id]['phone']          : '';
    $data['city']           = ($id!=='') ? $_SESSION['ads'][$id]['city']           : '';
    $data['category']       = ($id!=='') ? $_SESSION['ads'][$id]['category']       : '';
    $data['title']          = ($id!=='') ? $_SESSION['ads'][$id]['title']          : '';
    $data['description']    = ($id!=='') ? $_SESSION['ads'][$id]['description']    : '';
    $data['price']          = ($id!=='') ? $_SESSION['ads'][$id]['price']          : 0;
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
    ?>
    <form  id = 'anketForm' method="post" name = 'anketForm'>  
        <table border = "0" class = "table1">
            <col class="col1_1">
            <col class="col1_2">
            <tr> 
                <td></td>
                <td>
                    <label><input type="radio" <?php echo ($data['private']==1)?" checked=\"\"" : "" ?>checked="" value="1" name="private">Частное лицо</label> <label><input type="radio" <?php echo ($data['private']==0)?" checked=\"\"" : "" ?>value="0" name="private">Компания</label> </td></tr>
            <tr>
                <td>
                    <b id="seller_name">Ваше имя</b> </td>    
                <td> 
                <input type="text" maxlength="40" value="<?php echo $data['seller_name'] ?>" name="seller_name" id="fld_seller_name"> <td></tr>
            <tr>
                <td>
                    <b id="email">Электронная почта</b> </td>    
                <td> 
                <input type="text" value="<?php echo $data['email'] ?>" name="email" id="fld_email"> <td></tr>
            <tr>
                <td></td>    
                <td> 
                    <label for="allow_mails"> <input type="checkbox" <?php echo ($data['allow_mails']==1)?" checked=\"\"" : "" ?> value="0" name="allow_mails" id="allow_mails" <span>Я не хочу получать вопросы по объявлению по e-mail</span> </label> <td></tr>
            <tr>
                <td>
                    <label id="fld_phone_label" for="fld_phone"><b>Номер телефона</b></label> </td>
                <td> 
                <input type="text" value="<?php echo $data['phone'] ?>" name="phone" id="fld_phone"> <td></tr>
            <tr>
                <td>
                    <label for="region"><b>Город</b></label> </td>
                <td>
                    <select title="Выберите Ваш город" name="city" id="region" >            
                        <option disabled="disabled" <?php echo $cityIsChecked?"\"\"":"selected=\"\""?> >-- Выберите город --</option>
                        <?php
                        foreach ($cities as $key=>$value) {
                            $selected = ($key==$data['city']) ? 'selected=""' : ''; 
                            echo '<option data-coords=",," '.$selected.' value="'.$key.'">'.$value.'</option>';
                        }?>                            
            <tr>
                <td>
                    <label for="region"><b>Категория</b></label> </td>
                <td>
                    <select title="Выберите категорию объявления" name="category" id="region" >            
                        <option disabled="disabled" <?php echo $categoryIsChecked?"\"\"":"selected=\"\""?> >-- Выберите категорию объявления --</option>
                        <?php
                        foreach ($categories as $key=>$value) {
                            echo '<optgroup label='.$key.'>';
                            foreach ($value as $categoryId=>$categoryName) {
                                $selected = ($categoryId==$data['category']) ? 'selected=""' : ''; 
                                echo '<option '.$selected.' value="'.$categoryId.'">'.$categoryName.'</option>';
                            }
                            echo '</optgroup> ';
                        }?>                                        
            <tr>
                <td>
                    <label for="fld_title"><b>Название объявления</b></label> </td>    
                <td> 
                <input type="text" maxlength="50" value="<?php echo $data['title'] ?>" name="title" id="fld_title"> <td></tr>
            <tr>
                <td>
                    <label for="fld_description"><b>Описание объявления</b></label> </td>    
                <td> 
                    <textarea maxlength="200"  name="description" id="fld_description"><?php echo $data['description'] ?></textarea> <td></tr>
            <tr>
                <td>
                    <label id="price_lbl" for="fld_price"><b>Цена</b></label> </td>    
                <td> 
                    <input type="text" maxlength="9" value="<?php echo $data['price']?>" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span>  <td></tr>          
        </table> <br/>
        <input type="submit" value="Подтвердить" id="form_submit" name="submit" >
    </form>    
<?php
}

/* Проверка заполнения всех параметров формы */
function checkForm(&$data) {    
    $data['private']        = $_POST['private'];    
    $data['seller_name']    = $_POST['seller_name'];    
    $data['email']          = $_POST['email'];
    $data['allow_mails']    = isset($_POST['allow_mails']) ? 1 : 0;    
    $data['phone']          = $_POST['phone'];
    $data['city']           = isset($_POST['city']) ? $_POST['city'] : '';    
    $data['category']       = isset($_POST['category']) ? $_POST['category'] : ''; 
    $data['title']          = $_POST['title'];    
    $data['description']    = $_POST['description'];    
    $data['price']          = (float)$_POST['price'];          
    
    $errorList = array();
    if ($data['seller_name']=='') {
        $errorList[] = 'Укажите Ваше имя';
    }    
    if ($data['email']=='') {
        $errorList[] = 'Укажите Ваш адрес электронной почты';
    }
    if ($data['phone']=='') {
        $errorList[] = 'Укажите Ваш контактный телефон';
    }
    else if (!is_numeric($data['phone'])) {
        $errorList[] = 'В номере телефона должны быть только цифры';
    }
    if ($data['city']=='') {
        $errorList[] = 'Укажите город Вашего проживания';
    }    
    if ($data['category']=='') {
        $errorList[] = 'Укажите категорию Вашего объявления';
    }    
    if ($data['title']=='') {
        $errorList[] = 'Укажите название объявления';
    }    
    if ($data['description']=='') {
        $errorList[] = 'Укажите описание объявления';
    }
    if ($data['price']=='0') {
        $errorList[] = 'Укажите цену в рублях';
    }
    else if (!is_numeric($data['price'])) {
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
function showSessionList() {
    if (isset($_SESSION['ads']) && count($_SESSION['ads'])) {
        ?>
        <br/><b>Введённые объявления:</b><br/>
        <form id = 'sessionForm' method='post' name = 'sessionForm'>
        <table border = "0" class="table2">
        <col class="col2_1">
        <col class="col2_2">
        <col class="col2_3">
        <col class="col2_4">        
        <?php              
        foreach ($_SESSION['ads'] as $key => $value) { 
        ?>
        <tr><td> <a href= "?id=<?php echo $key."\"> ".$value['title']?></a> </td>
            <td> <?php echo $value['price']?> </td>
            <td> <?php echo $value['seller_name']?> </td>
            <td> <a href= "?del_id=<?php echo $key."\"> Удалить"?></a> </td></tr>            
        <?php
        }
        echo "</table></form> <br/>";        
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
        $data = isset($_GET['id']) ? FillData($_GET['id']) : FillData();        

        if (isset($_POST['submit'])) {
            if (checkForm($data)) {
                if(isset($_GET['id'])) {
                    $_SESSION['ads'][$_GET['id']] = $data;                    
                }
                else {
                    $_SESSION['ads'][] = $data;
                }
                $data = FillData();
                header("Location: /");      /* Возврат на первоначальную страницу без параметров $_GET */
            }
        }     
        
        if (isset($_GET['del_id'])) {
            unset($_SESSION['ads'][$_GET['del_id']]);    
            header("Location: /");      /* Возврат на первоначальную страницу без параметров $_GET */
        }
        
        showForm($data);
        showSessionList();
        ?>    
    </body>
</html>
