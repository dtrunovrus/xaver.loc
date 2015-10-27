{include file='header.tpl'}

{include file="mainForm.tpl"}

{if isset($adList.ads) && count($adList.ads)} 
    {include file="sessionList.tpl"}    
{/if}

{include file='footer.tpl'}