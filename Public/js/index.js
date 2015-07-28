 $(document).ready(function(){
    $(".message_head").toggle(function(){
        $(this).next(".message_body").show();
        $(this).children("span").toggleClass("d_icon");
        $(this).css("border-bottom","none");
        },
      function(){
        $(this).next(".message_body").hide();
        $(this).children("span").toggleClass("d_icon");        
       	$(this).css("border-bottom","1px solid #e6e6e6");
            }      
        );     
});

$(function(){
    $(".jf_rule ul li").click(function(){
        curLi=$(this); 
        $(".block").removeClass("block"); 
        $(".rule_content").eq($(".jf_rule ul li").index(curLi)).addClass("block"); 
       
        });
});

$(function(){
    $(".date_box a").toggle(function(){
        $(this).addClass("cur");
    },
    function(){
       $(this).removeClass("cur"); 
    }
    );
});