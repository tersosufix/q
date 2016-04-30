var main = function (){
    "use strict";
    var postComment = function () {
    var $tmpVar;
   if ($(".comment-input input").val() !== ""){
  $tmpVar = $("<p>").text($(".comment-input input").val());
  
  $(".comments").prepend($tmpVar);
  $tmpVar.slideDown(3000);
  
  
  $(".comment-input input").val("");
  
  $(".comments p:last-child").remove();
   }
      
};
$(".comment-input button").on("click", function(event){
    postComment();
  });
  
 $(".comment-input input").on("keypress", function(event){
    if (event.keyCode === 13){
 postComment();

    }
    });
 if($("p:nth-child(4)" === 4)){
    console.log("4 запись1");
 }
};
$(document).ready(main);
