<?php include "config/DB_connection.php";?>
<?php
/**its for me **/

if(isset($_SESSION['user_name'])){
    $userLoggedIn=$_SESSION['user_name'];
    $user_details_query=mysqli_query($connection,"SELECT * FROM users where
    username='$userLoggedIn'");
    $user=mysqli_fetch_array($user_details_query);
}

else{
    header("location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--javascipt-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <!--css-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/header_style.css">
    
</head>
<body>
    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Purbule Feed</a>  
        </div>
        <nav>
            <a href="<?php echo $userLoggedIn ; ?>">
               <?php 
                echo $user['first_name'];
                ?>
            </a>
            <a href="index.php"><i class="fas fa-home" style="font-size: 27px;"></i></a>
            <a href="#"><i class="fas fa-envelope" style="font-size: 27px;"></i></a>
            <a href="#"><i class="far fa-bell" style="font-size: 27px;"></i></a>
            <a href="#"><i class="fa fa-users" style="font-size: 27px;"></i></a>
            <a href="#"><i class="fa fa-cog" style="font-size: 27px;"></i></a>
            <a href="includes/handlers/logout.php"><i class="fa fa-sign-out-alt" style="font-size: 27px;"></i></a>   
        </nav>
    </div>
    <div class="wrapper">

        
   
