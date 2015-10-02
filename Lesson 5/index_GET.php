<?php
error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 5 Task 1 */
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
    if(is_null($id)) {
        header('HTTP/1.0 404 Not Found');
        exit;        
    }

    if ($id===false) {
        echo "<b>Новость с таким номером отсутствует.<br>".
             "Выберите одну из имеющихся:</b><br>";
        printNewsList($newsList);
    }
    else {
        echo $newsList[$id - 1] . "<br>";        
    } 
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>count($news))));

printNews($news, $id);

?>