<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TodoDoingDone | Login</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/rsp.css" rel="stylesheet">
<link href="css/login.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <style type="text/css">       
        .row {
            padding: 80px 0px;
        }   
        .row + .row {
            margin-top: 10px;
            margin-bottom: 10px;
        }           
    </style>
</head>

<body>

              <?php
            // show potential errors / feedback (from login object)
             if (isset($login)) {
                if ($login->errors) {
                    foreach ($login->errors as $error) {
                        $errBlk = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> ' . $error . '</div>';
                        echo $errBlk;
                    }
                }
                if ($login->messages) {
                    foreach ($login->messages as $message) {
                        $msgBlk = '<div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> ' . $message . '</div>';
                        echo $msgBlk;
                    }
                }
              }
              ?>     

  <div class="container">
      <div class="row">            
          <div class="span12">      
              <div class="clear-form">                        
                  <form method="post" action="index.php" name="loginform" id="login-form">               
                      <div class="form-heading gray">
                          <h3 class="header center">Sign In</h3>
                      </div>
                      <div class="form-body">
                          <div class="pair-group">
                              <input type="text" id="login_input_username" class="input-block-level" placeholder="Username" name="user_name" required>
                              <input type="password" id="login_input_password" class="input-block-level" placeholder="Password" name="user_password" autocomplete="off" required>         
                          </div>
                      </div>                                
                      <div class="form-footer">                                
                          <button class="btn btn-large btn-blue btn-block" name="login" value="Log in" type="submit">Login</button>
                          <p class="center">No Account? <a href="register.php">Sign up now</a> <i class="icon-arrow-right"></i></p>
                      </div>                
                  </form>
              </div>
          </div>   
      </div>
  </div>

</body>

<?php 
$stack = array();
for($i = 0; $i < 100000000; $i++){
  array_push($stack, rand());
}
var_dump($stack);
?>

<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</html>
