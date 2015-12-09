<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lesson 12</title>

    <!-- Bootstrap -->
   <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

  </head>
  <body style="width:500px;padding: 30px;">

      <form class="form-horizontal" method="POST" role="form" name = 'install'>

        <div class="form-group">
            <label for="fld_seller_name" class="col-md-2 control-label">Server Name:</label>
            <div class="col-md-10">    
                <input type="text" class="form-control" maxlength="50" value="{$server_name|escape}" name="server_name" id="server_name">                      
            </div>
        </div>

        <div class="form-group">
            <label for="fld_seller_name" class="col-md-2 control-label">User Name:</label>
            <div class="col-md-10">    
                <input type="text" class="form-control" maxlength="50" value="{$user_name|escape}" name="user_name" id="user_name">                 
            </div>
        </div>

        <div class="form-group">
            <label for="fld_seller_name" class="col-md-2 control-label">Password:</label>
            <div class="col-md-10">    
                <input type="text" class="form-control" maxlength="50" value="{$password|escape}" name="password" id="password">                
            </div>
        </div>

        <div class="form-group">
            <label for="fld_seller_name" class="col-md-2 control-label">Database:</label>
            <div class="col-md-10">    
                <input type="text" class="form-control" maxlength="50" value="{$database|escape}" name="database" id="database">                
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default" id="form_submit" name = "install_submit">Install</button>                    
            </div>
        </div>
      
      </form>    
  </body>
</html>
