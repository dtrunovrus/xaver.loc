{include file='header.tpl'}

{include file="$project_root/mainForm.php"}

{if isset($adList.ads) && count($adList.ads)} 
    {include file="$project_root/sessionList.php"}    
{/if}

{include file='footer.tpl'}