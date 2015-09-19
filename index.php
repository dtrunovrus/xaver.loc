<?php

error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Задание 1 */
$date = array();    
$days = array();    
$months = array();

echo ("В сгенерированном массиве получились даты:<br>");
for ($i = 0; $i < 5; $i++) {
    $date[] = rand(0, time());                          
    $days[$i] = (int)(date('d', $date[$i]));        
    $months[$i] = (int)date('m', $date[$i]);        
    echo (date('d.m.Y', $date[$i]) . "<br>");
}
echo ("Среди них ".min($days)." - минимальный день, ".max($months)."- максимальный месяц<br><br>");

sort($date);
$selected = array_pop($date);
echo('Переменная $selected без смены часового пояса: '.date('d.m.Y H:i:s',$selected)."<br>");
date_default_timezone_set('America/New_York');
echo('Переменная $selected в часовом поясе America/New_York: '.date('d.m.Y H:i:s',$selected));

?>
