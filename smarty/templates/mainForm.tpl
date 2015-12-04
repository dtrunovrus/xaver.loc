<form  id = 'anketForm' method="post" name = 'anketForm'>  
        <table border = "0" class = "table1">
            <col class="col1_1">
            <col class="col1_2">
            <tr> 
                <td></td>
                <td>
                    <label><input type="radio" {if !isset($data->physical) || $data->physical==1} " checked=\"\" " {else} "" {/if} value="1" name="physical">Частное лицо</label> <label><input type="radio" {if $data->physical==0} " checked=\"\" " {else} "" {/if} value="0" name="physical">Компания</label> </td></tr>
            <tr>
                <td>
                    <b id="seller_name">Ваше имя</b> </td>    
                <td> 
                <input type="text" maxlength="40" value="{$data->seller_name}" name="seller_name" id="fld_seller_name"> <td></tr>
            <tr>
                <td>
                    <b id="email">Электронная почта</b> </td>    
                <td> 
                <input type="text" value="{$data->email}" name="email" id="fld_email"> <td></tr>
            <tr>
                <td></td>    
                <td> 
                    <label for="allow_mails"> <input type="checkbox" value="1" {if $data->allow_mails==1} " checked=\"\" " {else} "" {/if} name="allow_mails" id="allow_mails" <span>Я не хочу получать вопросы по объявлению по e-mail</span> </label> <td></tr>
            <tr>
                <td>
                    <label id="fld_phone_label" for="fld_phone"><b>Номер телефона</b></label> </td>
                <td> 
                <input type="text" value="{$data->phone}" name="phone" id="fld_phone"> <td></tr>
            <tr>
                <td>
                    <label for="region"><b>Город</b></label> </td>
                <td>
                    <select title="Выберите Ваш город" name="city" id="region" >            
                        <option value =''>-- Выберите город --</option>  
                        {foreach from=$cities key=code item=city}                             
                            <option data-coords=",," {if $code==$data->city} " selected = \"\"" {else} "" {/if} value="{$code}">{$city}</option>
                        {/foreach}    
            <tr>
                <td>
                    <label for="region"><b>Категория</b></label> </td>
                <td>
                    <select title="Выберите категорию объявления" name="category" id="region" >            
                        <option value=''>-- Выберите категорию объявления --</option>
                        {foreach from=$categories key=category item=value}  
                            <optgroup label='{$category}'>
                            {foreach from=$value key=code item=name}          
                                <option data-coords=",," {if $code==$data->category} " selected = \"\"" {else} "" {/if} value="{$code}">{$name}</option>
                            {/foreach}  
                        {/foreach}                           
            <tr>
                <td>
                    <label for="fld_title"><b>Название объявления</b></label> </td>    
                <td> 
                <input type="text" maxlength="50" value="{$data->title}" name="title" id="fld_title"> <td></tr>
            <tr>
                <td>
                    <label for="fld_description"><b>Описание объявления</b></label> </td>    
                <td> 
                    <textarea maxlength="200"  name="description" id="fld_description">{$data->description}</textarea> <td></tr>
            <tr>
                <td>
                    <label id="price_lbl" for="fld_price"><b>Цена</b></label> </td>    
                <td> 
                    <input type="text" maxlength="9" value="{$data->price}" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span>  <td></tr>          
        </table> <br/>        
        <input type="hidden" value={if isset($data->show_id)} "{$data->show_id}"  {else} '' {/if} id="ad_hidden_info" name="show_id" > 
        <input type="submit" value="Подтвердить" id="form_submit" name="submit" >
    </form>    