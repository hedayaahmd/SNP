<?php
ob_start();
session_start();

$time_zone=date_default_timezone_set("Asia/Jerusalem");

$connection=mysqli_connect("localhost","root","","social_network_app");
//if($connection){ or use 
if(mysqli_connect_errno()){
   echo "faild connection" .mysqli_error($connection); 
}
 

?>