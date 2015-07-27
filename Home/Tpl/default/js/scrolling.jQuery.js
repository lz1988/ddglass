$.fn.scrolling = function(option,pcs){
	var _this = $(this),
		heights = _this.height(),
		_interval=3000,
		_h=option,
		_moving;
	_this.css({'overflow':'hidden','height':option*pcs});
	
	_this.hover(function(){
		clearInterval(_moving);
	},function(){
		_moving=setInterval(function(){
			var _field=_this.find('li:first');
			_field.animate({marginTop:-_h+'px'},600,function(){
				_field.css('marginTop',0).appendTo(_this);
			})
		},_interval);
	}).trigger('mouseleave');
}