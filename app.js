var main = function (){
    "use strict";
$(".comment-input button").on("click", function(event){
   var $tmpVar = $("<p>").$("text");
  $(".comments").append($tmpVar); 
});
};
$(document).ready(main);
