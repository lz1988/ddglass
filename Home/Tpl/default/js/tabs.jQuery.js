$.fn.tree = function(){
	
	var obj = $(this);
	obj.find('.parent').click(function(event){
		
		$(this).next().toggleClass('show');
		event.preventDefault();
	});
}
$.fn.TabADS = function(){
	var obj = $(this);
	var currentClass = "select";
	var tabs = obj.find(".tab-hd").find("li");
	var conts = obj.find(".tab-cont");
	var t;
	tabs.eq(0).addClass(currentClass);
	conts.hide();
	conts.eq(0).show();
	tabs.each(function(i){
		$(this).bind("mouseover",function(){
			 t = setTimeout(function(){
				conts.hide().eq(i).show();
				tabs.removeClass(currentClass).eq(i).addClass(currentClass);
			},300);
		}).bind("mouseout",function(){
			clearTimeout(t);
		});
	});
}
$.fn.modCity = function(){
	var selectBox = $('#modCity_link');
	var dropDown = $('#modCity');
	dropDown.bind('show',function(){  
		if(dropDown.is(':animated')){ return false; }  
		selectBox.addClass('expanded');
		dropDown.fadeIn();
	}).bind('hide',function(){
		if(dropDown.is(':animated')){ return false; }
		selectBox.removeClass('expanded');
		dropDown.fadeOut();  
	}).bind('toggle',function(){
		if(selectBox.hasClass('expanded')){  
			dropDown.trigger('hide');
		}else{
			dropDown.trigger('show');  
		}
	});
	selectBox.click(function(){
		dropDown.trigger('toggle');  
		return false;  
	}); 
	$(document).click(function(){
		dropDown.trigger('hide');
	});  
}

function Show_TabADSMenu(tabadid_num,tabadnum,tabNums){
	for(var i=0;i<tabNums;i++){document.getElementById("tabadcontent_"+tabadid_num+i).style.display="none";}
	for(var i=0;i<tabNums;i++){document.getElementById("tabadmenu_"+tabadid_num+i).parentNode.className="";}
	document.getElementById("tabadmenu_"+tabadid_num+tabadnum).parentNode.className="select";
	document.getElementById("tabadcontent_"+tabadid_num+tabadnum).style.display="block";
}





