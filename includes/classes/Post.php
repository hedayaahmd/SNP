<?php
class Post{
    private $user_obj;
    private $con ; 
    
    public function __construct($con ,$user){
        $this->con=$con ;
        $this->user_obj= new User($con,$user);
    }
    
    public function submitPost($body,$user_to){
        $body=strip_tags($body);//remove html tag
        $body=mysqli_real_escape_string($this->con,$body);
        $check_empty=preg_replace('/\s+/','',$body);
        if($check_empty != ""){
            
            //current date_create
            $date_added=date('Y-m-d H:i:s');
            //get user name
            $added_by=$this->user_obj->getUserName();
            
            //if user is on own profile user_to is none 
            if($user_to ==$added_by){
               $user_to="none"; 
            }
            
            $query=mysqli_query($this->con,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0')");
            $returned_id=mysqli_insert_id($this->con);
        }
        //insert notification 
        
        //update post count for user 
        $num_posts=$this->user_obj->getNumOfPosts();
        $num_posts++;
        $update_query=mysqli_query($this->con,"UPDATE users SET num_posts='$num_posts' where username='$added_by'");
        
        
        
        
        
    }
    
    public function loadPostsFriend($data ,$limit){
        $page=$data['page'];
        $userLoggedIn=$this->user_obj->getUserName();
        
        if($page==1){
            $start=0;
        }else {
            $start = ($page-1) * $limit ;
        }
        
        $str="";//string to return 
        $data_query=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");
        
        
        if(mysqli_num_rows($data_query)>0){
            
            $num_iteration =0 ; // number of  results checked 
            $count =0;
            
            
        while($row=mysqli_fetch_array($data_query)){
            $id=$row['id'];
            $body=$row['body'];
            $added_by=$row['added_by'];
            $date_time=$row['date_added'];
            //Prepare user_to string so it can be included even if not posted to a user
            if($row['user_to']=="none"){
                $user_to="";
            }else {
                $user_to_obj=new User($this-con,$row['user_to']);
                $user_to_name=$user_to_obj->getFullName();
                $user_to="to <a href='".$row['user_to']."'>".$user_to_name."</a>";
            }
            //check if the user closed his account his posts will not be show
             $added_by_obj=new User($this->con,$added_by);
            if($added_by_obj->isClosed()){
                continue;
            }
            $user_loggedIn_obj=new User($this->con,$userLoggedIn);
            if($user_loggedIn_obj->isFriend($added_by)){
            
            
            
            if($num_iteration++ < $start){
               continue;
            }
            //once 10 posts have been loaded break 
            if($count >$limit){
                break;
            }else {
                $count++ ;
            }
            $user_details_query=mysqli_query($this->con,"select first_name ,last_name,profile_pic from users where username='$added_by'");
            $user_row=mysqli_fetch_array($user_details_query);
            $first_name=$user_row['first_name'];
            $last_name=$user_row['last_name'];
            $profile_pic=$user_row['profile_pic'];
            ?>
            <script> 
						function toggle<?php echo $id; ?>(){

								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") {
                                    element.style.display = "none";
                                }
									
								else {
                                    element.style.display = "block";
                                }
									
							
						}

					</script>  
                
            <?php  
              $comments_check=mysqli_query($this->con,"select * from coments where post_id='$id'") ; 
                $comments_check_num=mysqli_num_rows($comments_check);
                
                
            //timeFrame
            $date_time_now=date("Y-m-d H:i:s");
            $start_date =new DateTime($date_time);//post date time
            $end_date=new DateTime($date_time_now);//current date time
            $interval=$start_date->diff($end_date);//difference between 2 dates 
            if($interval->y >= 1){
                if($interval==1){
                    $time_message=$interval->y."year ago";
                }else{
                    $time_message=$interval->y."years ago";
                }
                
            }// more than or equal 1 year 
            
            else if($interval->m >= 1){
                if($interval-> d==0){
                    $days =$interval->d."ago";
                }
                else if ($interval-> d==1){
                    $days=$interval->d."day ago";
                }
                else {
                    $days=$interval->d."days ago";
                }
                if($interval->m == 1){
                    $time_message=$interval->m." month".$days;
                }
                else {
                    $time_message=$interval->m." months".$days; 
                }
            }//less than year 
            
            else if ($interval->d >=1){
                if ($interval-> d==1){
                    $time_message="yestrday";
                }else {
                    $time_message=$interval->d."days ago";
                }
            }
            else if ($interval->h >=1){
               if ($interval-> h==1){
                    $time_message="hour ago";
                }else {
                    $time_message=$interval->h."hours ago";
                }   
            }
            else if ($interval->i >=1){
               if ($interval-> i==1){
                    $time_message="minute ago";
                }else {
                    $time_message=$interval->i."minutes ago";
                }   
            }
            else {
               if ($interval-> s<30){
                    $time_message="just now";
                }else {
                    $time_message=$interval->s."seconds ago";
                }   
            }
                
            $str .= "<div class='status_post' onClick='toggle$id()'>
             <div class='post_profile_pic'> 
             <img src='$profile_pic' width='50'>
             </div>
             <div class='posted_by' style= 'color:#acacac;'>
             <a href='$added_by' > $first_name $last_name </a>
              $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
             </div>
             <div id='post_body'>
             $body 
             <br>
             </div>
             <div class='newsFeedPostOptions'>
             comments($comments_check_num)&nbsp;&nbsp;&nbsp;
             </div>
            </div>
                <div class='post_comment' id='toggleComment$id' style='display:none;'>
                       <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' style='width: 100%;'>
                       </iframe>
                </div>
            <hr>";
          
            }//end of if checking the friend between 2 obj 
            
        }//end of while loop 
          if($count > $limit) 
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
			else 
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
            
            
            
        }
        echo $str ;
    }//end of function
}//end of class

?>