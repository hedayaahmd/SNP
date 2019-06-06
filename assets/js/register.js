$(document).ready(function(){
  //onclick sign up hide login and show reg form
    $("#signup").click(function(){
      $("#first").slideUp("slow",function(){
         $("#second").slideDown("slow"); 
      })  ;
    });
    
    $("#signin").click(function(){
      $("#second").slideUp("slow",function(){
         $("#first").slideDown("slow"); 
      })  ;
    });
    
    
    
    
});