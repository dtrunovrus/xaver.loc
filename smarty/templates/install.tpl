<form  id = 'install' method="post" name = 'install'>          
    Server Name: </br>
    <input type="text" maxlength="50" value="{$server_name|escape}" name="server_name" id="server_name"> </br>
    User Name: </br>
    <input type="text" maxlength="50" value="{$user_name|escape}" name="user_name" id="user_name"> </br>
    Password: </br>
    <input type="text" maxlength="50" value="{$password|escape}" name="password" id="password"> </br>
    Database: </br>
    <input type="text" maxlength="50" value="{$database|escape}" name="database" id="database"> </br></br>    
    <input type="submit" value="Install" id="form_submit" name="install_submit" > </br>    
</form>