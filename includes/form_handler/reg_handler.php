<?php
/**its for me **/

$first_name="";
$last_name="";
$reg_email="";
$confirm_email="";
$password="";
$confirm_password="";
$date="";
$err_array=array(); //holds error message
if(isset($_POST['register_btt'])){
    //first_name
    $first_name=strip_tags($_POST['first_name']);
    $first_name=str_replace(' ','',$first_name);
    $first_name=ucfirst(strtolower($first_name));
    $_SESSION['first_name']=$first_name;
    //last_name
    $last_name=strip_tags($_POST['last_name']);
    $last_name=str_replace(' ','',$last_name);
    $last_name=ucfirst(strtolower($last_name));
    $_SESSION['last_name']=$last_name;
    //reg_email
    $reg_email=strip_tags($_POST['reg_email']);
    $reg_email=str_replace(' ','',$reg_email);
    $reg_email=ucfirst(strtolower($reg_email));
    $_SESSION['reg_email']=$reg_email;
    //confirm_email
    $confirm_email=strip_tags($_POST['reg_email2']);
    $confirm_email=str_replace(' ','',$confirm_email);
    $confirm_email=ucfirst(strtolower($confirm_email));
    $_SESSION['reg_email2']=$confirm_email;
    //password
    $password=strip_tags($_POST['user_password']);
    //confirm_password
    $confirm_password=strip_tags($_POST['user_password2']);
    $date=date("Y-m-d");
    if($reg_email==$confirm_email){
        //check if email is in valid format
        if(filter_var($reg_email,FILTER_VALIDATE_EMAIL)){
            $reg_email=filter_var($reg_email,FILTER_VALIDATE_EMAIL);
            //check if email is already exist
            $email_check=mysqli_query($connection,"SELECT email FROM users where email='$reg_email'");
            $result=mysqli_num_rows($email_check);
            if($result>0){
                array_push($err_array,"email is already exist<br>");
            }
            
        }
        else {
            array_push($err_array,"invalid email format<br>");
        }
    }
    else {
        array_push($err_array,"Emails don't match<br>");
    }
    if(strlen($first_name)>25 || strlen($first_name)<2){
        array_push($err_array, "your name must at least from 2-25 character<br>");
    }
    if(strlen($last_name)>25 || strlen($last_name)<2){
        array_push($err_array,"your name must at least from 2-25 character<br>");
    }
    if($password <> $confirm_password){
        array_push($err_array,"mismatch password<br>");
    }else {
        if(preg_match('/[^A-Za-z0-9]/',$password)){
            array_push($err_array,"password must contain just character and numbers<br>");
           
        }
         if(strlen($password)>30 || strlen($password)<5){
            array_push($err_array," the password must be between 5-30 character<br>");
        }
        
    }
    if(empty($err_array)){
        $password=md5($password);//encrypt the password before sending to DB
        //generation a unique user name
        $user_name=strtolower($first_name."_".$last_name);
        $check_user_name=mysqli_query($connection,"SELECT username FROM users WHERE username='$user_name'");
        $i=0;
        while(mysqli_num_rows($check_user_name)!=0){
            $i++ ; 
            $user_name.="_".$i;
            $check_user_name=mysqli_query($connection,"SELECT username FROM users WHERE username='$user_name'");
            
        }
    
    //profile pic assignment
    $rand=rand(1,16);//random number between 1 and 2 
    $profile_pic="";
    switch($rand){
        case 1:$profile_pic="assets/images/profile_pic/defaults_pic/head_deep_blue.png";
            break;
        case 2:$profile_pic="assets/images/profile_pic/defaults_pic/head_alizarin.png";
            break;
        case 3:$profile_pic="assets/images/profile_pic/defaults_pic/head_amethyst.png";
            break;
        case 4:$profile_pic="assets/images/profile_pic/defaults_pic/head_belize_hole.png";
            break;
        case 5:$profile_pic="assets/images/profile_pic/defaults_pic/head_carrot.png";
            break;
        case 6:$profile_pic="assets/images/profile_pic/defaults_pic/head_emerald.png";
            break;
        case 7:$profile_pic="assets/images/profile_pic/defaults_pic/head_green_sea.png";
            break;
        case 8:$profile_pic="assets/images/profile_pic/defaults_pic/head_nephritis.png";
            break;
        case 9:$profile_pic="assets/images/profile_pic/defaults_pic/head_pete_river.png";
            break;
        case 10:$profile_pic="assets/images/profile_pic/defaults_pic/head_pomegranate.png";
            break;
        case 11:$profile_pic="assets/images/profile_pic/defaults_pic/head_pumpkin.png";
            break;
        case 12:$profile_pic="assets/images/profile_pic/defaults_pic/head_red.png";
            break;
        case 13:$profile_pic="assets/images/profile_pic/defaults_pic/head_sun_flower.png";
            break;
        case 14:$profile_pic="assets/images/profile_pic/defaults_pic/head_turqoise.png";
            break;
        case 15:$profile_pic="assets/images/profile_pic/defaults_pic/head_wet_asphalt.png";
            break;
        case 16:$profile_pic="assets/images/profile_pic/defaults_pic/head_wisteria.png";
            break;
        
    }
        $signup_date=date('Y-m-d');
        $query="INSERT INTO users(user_id,first_name, last_name, username, email, password, signup_date, profile_pic, num_posts, num_likes, user_closed, friend_array)";
        $query.=" VALUES('','$first_name','$last_name','$user_name','$reg_email','$password','$signup_date','$profile_pic','0','0','no',',')";
    $result=mysqli_query($connection,$query);
        array_push($err_array,"<span style='color:#14c800;'>you're all set ! goahead and login! </span><br>");
        $_SESSION['first_name']="";
        $_SESSION['last_name']="";
        $_SESSION['reg_email']="";
        $_SESSION['reg_email2']="";
        
        
        
    
  }  
    
}
?>