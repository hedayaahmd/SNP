<?php  
include("../../config/DB_connection.php");
include("../classes/User.php");
include("../classes/Post.php");

$limit = 10; //Number of posts to be loaded per call

$posts = new Post($connection, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriend($_REQUEST,$limit);
?>