<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TodoDoingDone | Register</title>
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
  // show potential errors / feedback (from registration object)
  if (isset($registration)) {
      if ($registration->errors) {
          foreach ($registration->errors as $error) {
              $errBlk = '<div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error!</strong> ' . $error . '</div>';
              echo $errBlk;
          }
      }
      if ($registration->messages) {
          foreach ($registration->messages as $message) {
              $msgBlk = '<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Message:</strong> ' . $message . '</div>';
              echo $msgBlk;
          }
      }
  }
  ?>
  <div class="container">
      <div class="row">
          <div class="span12">
              <div class="clear-form no-border">                                
                  <form method="POST" action="index.php?register" name="registerform">  
                      <div class="form-heading">
                          <h3 class="header">Create an account</h3>   
                          <hr/>                            
                      </div>  
                      <div class="form-body">
                          <span class="form-label">Enter your email address</span>
                          <input class="input-block-level" id="login_input_email" type="text" name="user_email" required >
                          <span class="form-label">Enter your username (only letters and numbers, 2 to 64 characters)</span>
                          <input class="input-block-level" id="login_input_username" type="text" name="user_name" required>
                          <span class="form-label">Enter password (min. 6 characters)</span>
                          <input class="input-block-level" id="login_input_password_new" type="password" name="user_password_new" required autocomplete="off">
                          <span class="form-label">Confirm password</span>
                          <input class="input-block-level" id="login_input_password_repeat" type="password" name="user_password_repeat" required autocomplete="off">                          
                         
<!--                               <p class="highlight">
                              By clicking on the "Create an account" button below, you certify that you have read and agree to our <a href="#">terms of use</a> and <a href="#">privacy policy</a>.
                          </p>   -->

                      </div>                                 
                      <div class="form-footer">                               
                          <button class="btn btn-large btn-green btn-block" type="submit" name="register" value="Register">Create an account</button> 
                          <p class="center">
                               Already have an account? <a href="index.php">Sign In</a>.
                          </p>
                      </div>                                         
                  </form>
              </div> 
          </div>
      </div>
  </div>

</body>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</html>