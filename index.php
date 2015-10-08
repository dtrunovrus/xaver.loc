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
    $cityIsChecked = ($data['city']=='')?false:true;
    ?>
    <form  id = 'anketForm' method="post" name = 'anketForm'>  
        <table border = "0" class = "table1">
            <col class="col1_1">
            <col class="col1_2">
            <tr> 
                <td></td>
                <td>
                    <label><input type="radio" <?echo ($data['private']==1)?" checked=\"\"" : "" ?>checked="" value="1" name="private">Частное лицо</label> <label><input type="radio" <? echo ($data['private']==0)?" checked=\"\"" : "" ?>value="0" name="private">Компания</label> </td></tr>
            <tr>
                <td>
                    <b id="seller_name">Ваше имя</b> </td>    
                <td> 
                <input type="text" maxlength="40" value="<? echo $data['seller_name'] ?>" name="seller_name" id="fld_seller_name"> <td></tr>
            <tr>
                <td>
                    <b id="email">Электронная почта</b> </td>    
                <td> 
                <input type="text" value="<? echo $data['email'] ?>" name="email" id="fld_email"> <td></tr>
            <tr>
                <td></td>    
                <td> 
                    <label for="allow_mails"> <input type="checkbox" <?echo ($data['allow_mails']==1)?" checked=\"\"" : "" ?> value="0" name="allow_mails" id="allow_mails" <span>Я не хочу получать вопросы по объявлению по e-mail</span> </label> <td></tr>
            <tr>
                <td>
                    <label id="fld_phone_label" for="fld_phone"><b>Номер телефона</b></label> </td>
                <td> 
                <input type="text" value="<? echo $data['phone'] ?>" name="phone" id="fld_phone"> <td></tr>
            <tr>
                <td>
                    <label for="region"><b>Город</b></label> </td>
                <td>
                    <select title="Выберите Ваш город" name="city" id="region" >            
                        <option disabled="disabled" <?echo $cityIsChecked?"\"\"":"selected=\"\""?> >-- Выберите город --</option>
                        <?
                        foreach ($cities as $key=>$value) {
                            $selected = ($key==$data['city']) ? 'selected=""' : ''; 
                            echo '<option data-coords=",," '.$selected.' value="'.$key.'">'.$value.'</option>';
                        }?>                            
            <tr>
                <td>
                    <label for="fld_title"><b>Название объявления</b></label> </td>    
                <td> 
                <input type="text" maxlength="50" value="<? echo $data['title'] ?>" name="title" id="fld_title"> <td></tr>
            <tr>
                <td>
                    <label for="fld_description"><b>Описание объявления</b></label> </td>    
                <td> 
                    <textarea maxlength="200"  name="description" id="fld_description"><? echo $data['description'] ?></textarea> <td></tr>
            <tr>
                <td>
                    <label id="price_lbl" for="fld_price"><b>Цена</b></label> </td>    
                <td> 
                    <input type="text" maxlength="9" value="<?echo $data['price']?>" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span>  <td></tr>          
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
        <tr><td> <a href= "?id=<?echo $key."\"> ".$value['title']?></a> </td>
            <td> <?echo $value['price']?> </td>
            <td> <?echo $value['seller_name']?> </td>
            <td> <input type="submit" value="Удалить" id="session_delete" name=<?echo "delete".$key?>></td></tr>
        <?
        }
        echo "</table></form> <br/>";        
    }    
}

/* Проверка была ли нажата кнопка "удалить". И если да, то какая именно. */
function checkDelButtonClick() {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'delete')!==false)
            return str_replace('delete', '', $key);
    }
    return false;
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
        $delbuttonnumb = checkDelButtonClick();

        if (isset($_POST['submit'])) {
            if (checkForm($data)) {
                $_SESSION['ads'][] = $data;
                $data = FillData();
            }
        }     
        elseif ($delbuttonnumb!==false) {
            unset($_SESSION['ads'][$delbuttonnumb]);    
            header("Location: /");      /* Возврат на первоначальную страницу без параметров $_GET */
        }
        showForm($data);
        showSessionList();
        ?>    
    </body>
</html>

