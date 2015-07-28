$(document).ready(function() {
	$('#tableClass tr:odd').addClass('odd');
	$('#tableClass tr:even').addClass('even'); //奇偶变色，添加样式
	$("#tableClass tr").height(20);
	$("#tableClass tr").hover(function(){
		$(this).removeClass("odd even");//为什么非要加上这一句  才能鼠标经过变色   按理说不通啊
		$(this).toggleClass("hackerhover");
		},function(){
			$(this).toggleClass("hackerhover");
			$("#tableClass tr:odd").addClass("odd");
			$("#tableClass tr:even").addClass("even");
	});
	
	$('.addclass input').focus(function (){
	   $('.addclass input').css('border','1px solid #ccc');
	   $(this).css('border','1px solid #4B751D');
    });
}); 

