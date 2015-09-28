<?php

error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
ini_set('display_errors', 1);

/* Lesson 4 */

$ini_string = '
[игрушка мягкая мишка белый]
цена = ' . mt_rand(1, 10) . ';
количество заказано = ' . mt_rand(1, 10) . ';
осталось на складе = ' . mt_rand(0, 10) . ';
diskont = diskont' . mt_rand(0, 2) . ';
    
[одежда детская куртка синяя синтепон]
цена = ' . mt_rand(1, 10) . ';
количество заказано = ' . mt_rand(1, 10) . ';
осталось на складе = ' . mt_rand(0, 10) . ';
diskont = diskont' . mt_rand(0, 2) . ';
    
[игрушка детская велосипед]
цена = ' . mt_rand(1, 10) . ';
количество заказано = ' . mt_rand(1, 10) . ';
осталось на складе = ' . mt_rand(0, 10) . ';
diskont = diskont' . mt_rand(0, 2) . ';
';
$bd = parse_ini_string($ini_string, true);

$typesTotal = 0;            /* Общее кол-во заказанных наименований */
$amountTotal = 0;           /* Общее кол-во заказанных единиц товара */
$priceTotal = 0;            /* Общая сумма заказа */
$amountForPay = array();    /* Массив с данными по кол-ву единиц на оплату для каждого наименования */
$notifications = array();   /* Массив для записи уведомлений */

/* Подсчёт скидки */
function calcDiscount($key, $data) {
    global $amountForPay;
    static $discount;

    switch ($data['diskont']) {
        case 'diskont0':
            $discount = 0;
            break;
        case 'diskont1':
            $discount = 0.1;
            break;
        case 'diskont2':
            $discount = 0.2;
            break;
    }
    if (($key == 'игрушка детская велосипед') and ( $amountForPay[$key] >= 3)) {
        $discount = 0.3;
    }
    return $discount;
}

echo "<font size = 5><b> Корзина: </b></font>";
echo "<table>
        <thead>
            <td><b> Наименование товара </b></td>
            <td><b> Кол-во, шт. </b></td>
            <td><b> Остаток на складе, шт. </b></td>
            <td><b> Цена за единицу, руб. </b></td>
            <td><b> Скидка, % </b></td>
            <td><b> Итоговая стоимость, руб. </b></td>
        </thead>";
foreach ($bd as $key => $value) {

    if ($value['количество заказано'] <= $value['осталось на складе']) {
        $amountForPay[$key] = $value['количество заказано'];
    } else {
        $amountForPay[$key] = $value['осталось на складе'];
        $noteText = "К сожалению нужного количества товара \"" . $key . "\" не оказалось на складе. ";
        if ($value['осталось на складе'] > 0) {
            $noteText .= "В наличии имеется только " . $value['осталось на складе'] . "шт.";
        }
        $notifications[] = $noteText;
    }

    if ($amountForPay[$key] > 0) {
        $typesTotal++;
        $amountTotal += $amountForPay[$key];
    }

    $discount = 'calcDiscount'; /* по заданию - переменная функция */
    $price = $value['цена'] * $amountForPay[$key] * ( 1 - $discount($key, $value));
    $priceTotal += $price;

    echo "<tr>
            <td>" . $key . "</td>
            <td>" . $value['количество заказано'] . "</td>
            <td>" . $value['осталось на складе'] . "</td>
            <td>" . $value['цена'] . "</td>            
            <td>" . ($discount($key, $value) * 100) . "</td>
            <td>" . $price . "</td>
         </tr>";
}
echo "</table>";

echo "<br><font size = 4><b> Итого: </b></font>";
echo "<br>Наименований заказано: " . $typesTotal;
echo "<br>Общее кол-во товаров: " . $amountTotal;
echo "<br>Общая сумма заказа: " . $priceTotal . "<br>";

if (count($notifications) > 0) {
    echo "<br><font size = 3><b> Уведомления: </b></font>";
    foreach ($notifications as $value) {
        echo "<br> -" . $value;
    }
}

if ($amountForPay['игрушка детская велосипед'] >= 3) {
    echo "<br><font size = 3><b> Скидки: </b></font>" .
         "<br>-При покупке от 3шт. товара \"игрушка детская велосипед\" Вам предоставляется скидка 30%";
}
?>
