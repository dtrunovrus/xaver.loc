<br/><b>Введённые объявления:</b><br/>
<table border = "0" class="table2">
    <col class="col2_1">
    <col class="col2_2">
    <col class="col2_3">
    <col class="col2_4">  
    
    {foreach from=$adList.ads key=ad item=value}        
    <tr><td> <a href= "?id={$ad}">{$value.title}</a> </td>
        <td>{$value.price}</td>
        <td>{$value.seller_name|escape:'html'}</td>
        <td> <a href= "?del_id={$ad}"> Удалить</a> </td></tr>            
    {/foreach}
    </table><br/>
    