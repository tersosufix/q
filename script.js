var main = function () {
    "use strict";
   $(".btn btn-primary").on("click", function (events){
 var $drawHere =$("<p>").text("text asdasdasd");
 $(".data-select").append($drawHere);
 console.log("test11111");
    });
};
$(document).ready(main);