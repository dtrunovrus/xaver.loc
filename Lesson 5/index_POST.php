<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 5 Task 2 */
$news = 'Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';
$news = explode("\n", $news);

/* Вывод всего списка новостей */
function printNewsList($news) {
    foreach ($news as $key => $value) {
        echo ($key + 1) . ". " . $value . ".<br>";
    }
}

/* Вывод новости из списка по id */
function printNews($newsList, $id) {       
    if (is_numeric($id)) {
        if (in_array($id, range(1, count($newsList)))) {
            echo $newsList[$id - 1] . "<br>";
        }
        else {
            echo "<b>Новость с таким номером отсутствует.<br>".
                 "Выберите одну из имеющихся:</b><br>";
                printNewsList($newsList);
        }
    }       
}

$id = isset($_POST['id'])?$_POST['id']:null;

printNews($news, trim($id));
echo "<br>";
?> 

<html>
    <body>     
        <form method="post">            
            <b>Id Новости:</b><input type="text" name="id" value=""><br>
            <input type="submit" value="Поиск" name="Поиск">
        </form>
    </body>
</html> 