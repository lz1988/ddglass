$.fn.gallery = function(){
	var self = $(this),
		page = self.find('#pageList'),
		data_node = page.find('.item'),
		data = [],
		i = 0,
		len = data_node.length,
		height = 0,
		prev_s,
		next_s,
		height_s,
		timer,
		img = $('<img src="" style="visibility:hidden;" id="graphics" class="graphics" alt="" />'),
		next_page = $('<a href="#" class="btn next" id="next">下一页</a>'),
		prev_page = $('<a href="#" class="btn prev" id="prev">上一页</a>'),
		s_prev_page = $('<div class="photoMenu_prev" id="prevPhoto"><div class="menuPrev" id="menuPrev"><s class="s hide"></s></div><div class="prevPhotoBg"></div></div>'),
		s_next_page = $('<div class="photoMenu_next" id="nextPhoto"><div class="menuNext" id="menuNext"><s class="s hide"></s></div><div class="prevPhotoBg"></div></div>'),
		player = $('<a href="#" id="player" class="players">自动播放</a>');
		stoper = $('<a href="#" id="stoper" class="stoper hide">停止播放</a>');

	var init = function(){
		data_node.each(function(index){
			data.push($(this).attr('href'));
		});
		self.prepend(img).prepend(s_prev_page).prepend(s_next_page);
		page.append(next_page).prepend(prev_page).prepend(player).prepend(stoper);
		prev_s = s_prev_page.find('.s');
		next_s = s_next_page.find('.s');
		to_transparent(0);
		data_node.eq(0).addClass('cur');
		img.attr('src',data[0]).css({'visibility':'visible'});
		img.load(function(){
			height = img.height();
			setTimeout(function(){heights();},100);
		});
		s_prev_page.hover(function(){prev_s.toggleClass('hide');});
		s_next_page.hover(function(){next_s.toggleClass('hide');});
	}();//初始化
	function change(index){
		img.attr('src',data[index]);
		height = $('#graphics').height();
		data_node.removeClass('cur').eq(index).addClass('cur');
		to_transparent(index);
		img.load(function(){
			height = img.height();
			setTimeout(function(){heights();},100);
		});
	}
	function heights(){
		$('#nextPhoto,#prevPhoto,#menuPrev,#menuNext,.prevPhotoBg').css({'height':height});
		height_s = (height-10)/2;
		prev_s.css({'margin-top':height_s});
		next_s.css({'margin-top':height_s});
	}
	function to_transparent(index){
		next_page.css({'opacity':'1','cursor':'pointer'});
		prev_page.css({'opacity':'1','cursor':'pointer'});
		next_s.removeClass('hides');
		prev_s.removeClass('hides');
		if(index==len-1){
			next_page.css({'opacity':'.3','cursor':'default'});
			next_s.addClass('hides');
			stopPlayer();
		}
		if(index==0){
			prev_page.css({'opacity':'.3','cursor':'default'});
			prev_s.addClass('hides');
		}
	}
	function next(){
		i<len-1&&change(++i);
	}
	function prev(){
		i>0&&change(--i);
	}
	//事件绑定
	next_page.bind('click',function(event){
		next();
		event.preventDefault();
	});
	prev_page.bind('click',function(event){
		prev()
		event.preventDefault();
	});
	s_next_page.bind('click',function(event){
		next();
		event.preventDefault();
	});
	s_prev_page.bind('click',function(event){
		prev()
		event.preventDefault();
	});
	page.delegate(".item", "click", function(event){
		i = $(this).index('.item');
		change(i);
		event.preventDefault();
	});
	//自动播放
	function autoPlayer(){
		player.addClass('hide');
		stoper.removeClass('hide');
		timer = setInterval(next,2000);
	}
	function stopPlayer(){
		stoper.addClass('hide');
		player.removeClass('hide');
		clearInterval(timer);
	}
	player.click(function(event){
		i<len-1&&autoPlayer();
		event.preventDefault();
	});
	stoper.click(function(event){
		stopPlayer();
		event.preventDefault();
	});
}











