$.fn.changeList = function(){
	var _this = $(this);
	_this.children('li').each(function(){
		$(this).mouseover(function(){_this.children('li').removeClass('open');$(this).addClass('open');});
	});
}
$.fn.changeList2 = function(){
	var _this = $(this);
	_this.children('li').each(function(){
		$(this).mouseover(function(){_this.children('li').removeClass('frist');_this.children('li').children('.img').hide();$(this).addClass('frist');$(this).children('.img').show();});
	});
}