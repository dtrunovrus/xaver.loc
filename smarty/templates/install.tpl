<form  id = 'install' method="post" name = 'install'>          
    Server Name: </br>
    <input type="text" maxlength="50" value="{$server_name}" name="server_name" id="server_name"> </br>
    User Name: </br>
    <input type="text" maxlength="50" value="{$user_name}" name="user_name" id="user_name"> </br>
    Password: </br>
    <input type="text" maxlength="50" value="{$password}" name="password" id="password"> </br>
    Database: </br>
    <input type="text" maxlength="50" value="{$database}" name="database" id="database"> </br></br>    
    <input type="submit" value="Install" id="form_submit" name="install_submit" > </br>    
</form>