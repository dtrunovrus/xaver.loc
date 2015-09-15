<?php

error_reporting(E_ALL|E_ERROR|E_PARSE|E_WARNING);
ini_set('display_errors',1);

/* Задание 1 */
$name = 'Дмитрий';
$age = 27;
echo "Меня зовут $name <br/>Мне $age лет";
echo "<br/><br/>";

unset($name);
unset($age);

/* Задание 2 */
define('MYCITY','Новосибирск');
If (MYCITY){
    echo MYCITY;
}
define('MYCITY','Красноярск');
echo "</br><br/>";

/* Задание 3 */
$book = array();
$book['title'] = 'Ночь Дракона';
$book['author'] = 'Ричард А.Кнаак';
$book['pages'] = 500;
echo 'Недавно я прочитал книгу '.$book['title'].
     ', написанную автором '.$book['author'].'. '.
     'Я осилил все '.$book['pages'].
     ' страниц. Мне она очень понравилась.';
echo "</br></br>";

/* Задание 4 */
$books[] = array ('title'=>'Круг Ненависти', 'author'=>'Кейт ДеКандидо', 'pages'=>500);
$books[] = array ('title'=>'Душа Демона', 'author'=>'Ричард А.Кнаак', 'pages'=>500);
echo 'Недавно я прочитал книги '.$books[0]['title'].' и '.$books[1]['title'].
     ' написанные соответственно '.$books[0]['author'].' и '.$books[1]['author'].'. '.
     'Я осилил в сумме '.($books[0]['pages']+$books[1]['pages']).
     ' страниц. Не ожидал от себя такого.';
?>
