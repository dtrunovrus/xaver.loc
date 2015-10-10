<br/><b>Введённые объявления:</b><br/>
<form id = 'sessionForm' method='post' name = 'sessionForm'>
    <table border = "0" class="table2">
        <col class="col2_1">
        <col class="col2_2">
        <col class="col2_3">
        <col class="col2_4">        
        <?php
        foreach ($session['ads'] as $key => $value) {
            ?>
            <tr><td> <a href= "?id=<?php echo $key . "\"> " . $value['title'] ?></a> </td>
                        <td> <?php echo $value['price'] ?> </td>
                        <td> <?php echo $value['seller_name'] ?> </td>
                        <td> <a href= "?del_id=<?php echo $key . "\"> Удалить" ?></a> </td></tr>            
            <?php
        }
        echo "</table></form> <br/>";
        ?>