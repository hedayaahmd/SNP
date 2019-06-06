<?php
class User{
    private $user;
    private $con ; 
    
    public function __construct($con ,$userLogged){
        $this->con=$con ;
        $user_details_query=mysqli_query($con,"select * from users where username='$userLogged'");
        $this->user=mysqli_fetch_array($user_details_query);
    }
    
    public function getFullName(){
        $username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
        
    }
    
    public function getUserName(){
        return $this->user['username'];
    }
    
    public function getNumOfPosts(){
        $username= $this->user['username'];
        $query =mysqli_query($this->con,"SELECT num_posts FROM users WHERE username ='$username' ");
        $row=mysqli_fetch_array($query);
        return $row['num_posts'];
    }
    
    public function isClosed(){
        $username= $this->user['username'];
        $query=mysqli_query($this->con,"SELECT user_closed from users where username='$username'");
        $row=mysqli_fetch_array($query);
        if($row['user_closed']=="yes"){
            return true;
        }else {
            return false;
        }
    }
    
    public function isFriend($user_name_toCheck){
        $userName_comma=",".$user_name_toCheck.",";
        if((strstr($this->user['friend_array'],$userName_comma)) || 
           $user_name_toCheck == $this->user['username']){
           return true; 
        }else {
            return false ;
        }
    }
    
    public function getProfilePic(){
        $username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'] ;
    }
    
}
?>