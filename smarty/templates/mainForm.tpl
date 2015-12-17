<div class = "row">
    <div class = "col-md-6">  
        <form class="form-horizontal" method="POST" role="form">

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <div class = "row">
                        <div class = "col-md-5">  
                            <div class="radio">
                                <label>
                                    <input type="radio" {if $data instanceof IndividualAd} " checked=\"\" " {else} "" {/if} value="1" name="physical">Частное лицо
                                </label>
                            </div>
                        </div>
                        <div class = "col-md-5">  
                            <div class="radio">
                                <label>
                                    <input type="radio" {if $data instanceof CompanyAd} " checked=\"\" " {else} "" {/if} value="0" name="physical">Компания
                                </label>
                            </div>
                        </div>
                    </div>    
                </div>        
            </div>          

            <div class="form-group">
                <label for="fld_seller_name" class="col-md-2 control-label">Ваше имя</label>
                <div class="col-md-10">          
                    <input type="text" class="form-control" maxlength="40" value="{$data->getSeller_name()}" name="seller_name" id="fld_seller_name" placeholder="Ваше имя">
                </div>
            </div>

            <div class="form-group">
                <label for="fld_email" class="col-md-2 control-label">e-mail</label>
                <div class="col-md-10">          
                    <input type="text" class="form-control" value="{$data->getEmail()}" name="email" id="fld_email" placeholder="e-mail"> 
                </div>
            </div>

            <div class="checkbox">
                <label>
                    <div class="col-md-offset-2 col-md-10">
                        <input type="checkbox" value="1" {if $data->getAllow_mails()==1} " checked=\"\" " {else} "" {/if} name="allow_mails" id="allow_mails" <span>Я не хочу получать вопросы по объявлению по e-mail</span> 
                    </div>
                </label>
            </div>

            <div class="form-group">
                <label for="fld_phone" class="col-md-2 control-label">Номер телефона</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="{$data->getPhone()}" name="phone" id="fld_phone" placeholder="Номер телефона">           
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Город</label>
                <div class="col-md-10">
                    <select class="form-control" name="city" >                    
                        <option value =''>-- Выберите город --</option>  
                        {foreach from=$cities key=code item=city}                             
                            <option data-coords=",," {if $code==$data->getCity()} " selected = \"\"" {else} "" {/if} value="{$code}">{$city}</option>
                        {/foreach}                
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Категория</label>
                <div class="col-md-10">
                    <select class="form-control" name="category">        
                        <option value=''>-- Выберите категорию объявления --</option>
                        {foreach from=$categories key=category item=value}  
                            <optgroup label='{$category}'>
                                {foreach from=$value key=code item=name}          
                                    <option data-coords=",," {if $code==$data->getCategory()} " selected = \"\"" {else} "" {/if} value="{$code}">{$name}</option>
                                {/foreach}  
                            {/foreach}   
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="fld_title" class="col-md-2 control-label">Название</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="50" value="{$data->getTitle()}" name="title" id="fld_title" placeholder="Название объявления">          
                </div>
            </div>

            <div class="form-group">
                <label for="fld_description" class="col-md-2 control-label">Описание</label>
                <div class="col-md-10">
                    <textarea maxlength="200" class="form-control" rows="3" name="description" id="fld_description">{$data->getDescription()}</textarea>          
                </div>
            </div>

            <div class="form-group">
                <label for="fld_price" class="col-md-2 control-label">Цена</label>        
                <div class="col-md-10">              
                    <input type="text" class="form-control" maxlength="9" value="{$data->getPrice()}" name="price" id="fld_price">          
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn btn-default" id="submit" name = "submit">Отправить</button>                    
                </div>
            </div>

            <input type="hidden" value={if $data->getId()!=''} "{$data->getId()}"  {else} '' {/if} id="ad_hidden_info" name="id" > 

        </form>      
    </div>

    <div class = "col-md-6">
        {if count($adList)} 
            {include file="sessionList.tpl"}    
        {/if}     
    </div>  

</div>