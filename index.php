 <?php include "includes/header.php" ;
include "includes/classes/User.php";
include "includes/classes/Post.php";

?>
<?php
if(isset($_POST['post'])){
    $post=new Post($connection,$userLoggedIn);
    $post->submitPost($_POST['post_text'],"none");
}
?>
<div class="user_details column">
   <a href="<?php echo $userLoggedIn ; ?>"><img src="<?php echo $user['profile_pic'] ; ?>" alt="profile_pic"></a> 
   <div class="user_details_left_right">
   <a href="<?php echo $userLoggedIn ; ?>">
   <?php
    echo $user['first_name']." ".$user['last_name'];
    ?>
    </a> 
    <br>
    <?php
       echo "POSTS : ".$user['num_posts']."<br>";
       echo "LIKES : ".$user['num_likes'];
       ?>
    </div>
 
</div>
   <div class="main_column column">
       <form action="index.php" class="post_form" method="post">
           <textarea name="post_text" id="post_text"  placeholder="Got somthing to say !"></textarea>
           <input type="submit" name="post" value="Post" id="post_button">
           <hr>   
       </form>
       <div class="posts_area">
           
       </div>
       <img id="loading" src="assets/images/icon/loading.gif">
    </div>
    <script>
        //for infinte scrolling bar endless posts view 
        var userLoggedIn= '<?php echo $userLoggedIn ;?>';
        $(document).ready(function(){
           $('#loading').show(); 
            //orginal ajax request for loading first posts
            $.ajax({
              url:"includes/handlers/ajax_load_posts.php",
                type:"POST" ,
                data:"page=1&userLoggedIn="+userLoggedIn,
                cashe:false,
                success:function(data){
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });
      
        
        $(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();
          
            if(($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7)&& noMorePosts == 'false' ){
			/**if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {**/
				$('#loading').show();
                
				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(response) {
                        
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())
              });//end of doc ready 
</script>
 </div>
</body>
</html>

