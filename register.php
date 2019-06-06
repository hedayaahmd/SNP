<?php require "config/DB_connection.php";
/**its for me **/
?>
<?php require "includes/form_handler/reg_handler.php";?>
<?php require "includes/form_handler/login_handler.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register page</title>
    <link rel="stylesheet" type="text/css" href="assets/css/reg_styling.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
 <?php
    if(isset($_POST["register_btt"])){
        echo '
        <script>
        $(document).ready(function(){
          $("#first").hide();
          $("#second").show();
        });
        </script>
        ';
    }
    ?>
<div class="wrapper">
  <div class="login_box">
   <div class="login_header">
       <h1>Purble Feed</h1>
       login or sign up !
   </div>
   <div id="first">
      <form action="" method="post">
      <input type="email" placeholder="Email Addresa" name="log_email"
     value="<?php 
            if(isset($_SESSION['log_email'])){
                echo $_SESSION['log_email'];
            }
     ?>" required>
      <br>
      <input type="password" placeholder="Password" name=log_password>
      <br>
      <input type="submit" name="login_button" value="Login">
      <br>
      <?php
      if(in_array("incorrect email or password try again !<br>",$err_array)){
        echo "incorrect email or password try again !<br>";  
      }
          ?>
     <br>
     <a href="#" id="signup" class="signup">need an account ? register here !</a>
  </form> 
   </div>



   
   <div id="second">
    <form action="register.php" method="post">
       <input type="text" name="first_name" placeholder="first name" 
       value="<?php 
              if(isset($_SESSION['first_name'])){
                  echo $_SESSION['first_name'];
              }
              ?>" 
              required>
       <br>
       <?php
       if(in_array("your name must at least from 2-25 character<br>",$err_array))echo "your name must at least from 2-25 character<br>" ; 
       ?>
       <input type="text" name="last_name" placeholder="last name" 
      value="<?php
             if(isset($_SESSION['last_name'])){
                 echo $_SESSION['last_name'];
             }
             ?>"
          required>
       <br>
       <?php
       if(in_array("your name must at least from 2-25 character<br>",$err_array))echo "your name must at least from 2-25 character<br>" ; 
       ?>
       <input type="email" name="reg_email" placeholder="email" 
       value="<?php 
              if(isset($_SESSION['reg_email'])){
                  echo $_SESSION['reg_email'];
              }
              ?>"
       required>
       <br>
       <?php
       if(in_array("email is already exist<br>",$err_array))echo "email is already exist<br>";
       else if(in_array("invalid email format<br>",$err_array)) echo "invalid email format<br>";
       else if(in_array("Emails don't match<br>",$err_array)) echo "Emails don't match<br>";
       ?>
       
       <input type="email" name="reg_email2" placeholder="confirm email" 
       value="<?php 
              if(isset($_SESSION['reg_email2'])){
                  echo $_SESSION['reg_email2'];
              }
              ?>"
       required>
       <br>
       <input type="password" name="user_password" placeholder="password" required>
       <br>
       <?php
       if(in_array("mismatch password<br>",$err_array))echo "mismatch password<br>";
       else if (in_array("password must contain just character and numbers<br>",$err_array))echo "password must contain just character and numbers<br>";
       else if (in_array(" the password must be between 5-30 character<br>",$err_array)) echo " the password must be between 5-30 character<br>";
       ?>
       <input type="password" name="user_password2" placeholder="confirm password" required>
       <br>
       <input type="submit" name="register_btt" value="Register">
       <br>
       <?php if(in_array("<span style='color:#14c800;'>you're all set ! goahead and login! </span><br>",$err_array))  echo "<span style='color:#14c800;'>you're all set ! goahead and login! </span><br>"?>
       <a href="#" id="signin" class="signin">already have an account ! sign in here </a>
   </form>
   </div>
  </div>
</div>
 
</body>
</html>