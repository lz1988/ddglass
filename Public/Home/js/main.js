//详情页 start

   //详情底部，券，惠，团
	$('.mian_det .discount li').each(function(){
		$(this).click(function(){
			if($(this).hasClass('cur')){
				$(this).removeClass('cur');
				$(this).siblings().children('p').slideUp(300);
				$(this).children('p').slideUp(300);
			}else{
				$(this).children('p').slideDown(300);
				$(this).addClass('cur').siblings().removeClass('cur');
				$(this).siblings().children('p').slideUp(300);
			}				
		});
	});
	
	//纠错弹出层垂直居中
	var $det_error_con=$('.det_error_con');
	var errorHeight=$det_error_con.height();
    $det_error_con.css('margin-top', -errorHeight/2);
	
	//点击纠错弹出纠错内容
	var $det_error=$('.det_error');
	var $cancel=$det_error_con.find('.cancel');
	$('.f_det ul li').eq(2).on('click',function(){		
		$det_error.addClass('det_error_show');		
	});
	$cancel.on('click',function(){
		$det_error.removeClass('det_error_show');
	})
//详情页  end

//评论页 start
	//评分星星等级
	$('.main_comm .score a').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
	
	//评论列表页
	//排序
	function sort(){
		var $sorting_btns=$('.sorting .sorting_btn a');
		var $sorting_cons=$('.sorting .sorting_con').find('ul');
		
		$sorting_btns.toggle(function(){
			var $index=$sorting_cons.eq($(this).index());
			if($index.hasClass('cur')){
				$index.removeClass();
			}else{
				$index.addClass('cur').siblings().removeClass();
			}
		},function(){
			var $index=$sorting_cons.eq($(this).index());
			if($index.hasClass('cur')){
				$index.removeClass();
			}else{
				$index.addClass('cur').siblings().removeClass();
			}
		});
				
		$sorting_cons.on('click',function(){
			$(this).removeClass('cur');
		})
		
	};
//评论 end
