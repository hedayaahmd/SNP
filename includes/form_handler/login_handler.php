<?php 
/**its for me **/

if(isset($_POST['login_button'])){
    $email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL);
    $_SESSION['log_email']=$email;
    $password=md5($_POST['log_password']);
    
    $query="SELECT * FROM users WHERE ";
    $query.="email='$email' AND ";
    $query.="password='$password' ";
    
    $check_exsit_query=mysqli_query($connection,$query);
    $result_rows=mysqli_num_rows($check_exsit_query);
    
    if($result_rows==1){
        $row=mysqli_fetch_array($check_exsit_query);
        $user_name=$row['username'];
        $user_closed_query=mysqli_query($connection,"SELECT * FROM users where email='$email' and user_closed='yes'");
        if(mysqli_num_rows($user_closed_query)==1){
            $reOpen_account=mysqli_query($connection,"UPDATE users SET user_closed='no' where email='$email'");
        }
        $_SESSION['user_name']=$user_name;
       
   echo '<script>console.log("'."$user_name".'")</script>';

        header("Location: index.php");
        exit();
    }else {
        array_push($err_array,"incorrect email or password try again !<br>");
    }
}
?>