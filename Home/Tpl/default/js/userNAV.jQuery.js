$.fn.userNAV = function(){
	var _this = $(this);
	var parent = _this.find('.parent');
	parent.bind('click',function(event){
		$(this).siblings('.icon').toggleClass('close');
		$(this).siblings('.son').toggleClass('hide');
		event.preventDefault();
	});
}