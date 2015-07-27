// JavaScript Document

$(function(){   
        var aMenuTwo = $(".nav_c");
        $(".footer_nav ul li > .nav_t").each(function (i) {
            $(this).click(function () {
                if ($(aMenuTwo[i]).css("display") == "block") {
                    $(aMenuTwo[i]).slideUp(300);                    
                } else {
                    for (var j = 0; j < aMenuTwo.length; j++) {
                        $(aMenuTwo[j]).slideUp(300);                        
                    }
                    $(aMenuTwo[i]).slideDown(300);                  
                }
                
            });

        });
        
    });
 
$(document).ready(function(){
    $(".nav_last a").last().css("border-bottom","none");
    $("#num1 a").last().css("border-bottom","none");
    $("#num2 a").last().css("border-bottom","none");
    $(".content").bind("click", function(event) {
        $(".footer_nav ul li > .nav_c").hide();
      }); 
    $(".content").bind("touchmove", function(event) {
        $(".footer_nav ul li > .nav_c").hide();
      }); 
    
});