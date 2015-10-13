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
                    <label for="allow_mails"> <input type="checkbox" <?php echo ($data['allow_mails']==1)?" checked=\"\"" : "" ?> value="1" name="allow_mails" id="allow_mails" <span>Я не хочу получать вопросы по объявлению по e-mail</span> </label> <td></tr>
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
                        <option value =''>-- Выберите город --</option>
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
                        <option value=''>-- Выберите категорию объявления --</option>
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
        <input type="hidden" value="<?php echo isset($data['data_id'])?$data['data_id']:''?>" id="<?php echo 'ad_hidden_info'?>" name="data_id" > 
        <input type="submit" value="Подтвердить" id="form_submit" name="submit" >
    </form>    
