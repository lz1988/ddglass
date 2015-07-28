/**
 *栏目树分级显示下拉菜单组件
 *作者：CandySunPlus 孙凤鸣
 *example:
 *var colObj2 = {"Items":[
 *				{"name":"菜单项目标题1","topid":"0","colid":"1","value":"菜单项目标题1","fun":function(){}},	
 *				...
 *				]}
 *$("#div").mlnColsel(colObj,{
 *				title:"栏目下拉菜单",
 *				value:"-1",
 *				width:100
 *			});
 *参数：topid 栏目所属，0为一级
 *		colid 栏目ID，0为一级
 *		fun 回调函数
 **/
 (function($){
	$.fn.mlnColsel=function(data,setting){
		var dataObj={"Items":[
			{"name":"mlnColsel","topid":"-1","colid":"-1","value":"-1","fun":function(){alert("undefined!");}}
		]};
		var settingObj={
			title:"请选择",
			value:"-1",
			width:100
		};
		
		settingObj=$.extend(settingObj,setting);
		dataObj=$.extend(dataObj,data);
		
		var $this=$(this);
		var $colselbox=$(document.createElement("a")).addClass("colselect").attr({"href":"javascript:;"});
		var $colseltext=$(document.createElement("span")).text(settingObj.title);
		var $coldrop=$(document.createElement("ul")).addClass("dropmenu");
		var selectInput = $.browser.msie?document.createElement("<input name="+$this.attr("id")+" />"):document.createElement("input");
 			selectInput.type="hidden";
 			selectInput.value=settingObj.value;
 			selectInput.setAttribute("name",$this.attr("id"));
		var ids=$this.attr("id");
		$this.onselectstart=function(){return false;};
		$this.onselect=function(){document.selection.empty()};
		$colselbox.append($colseltext);
		$this.addClass("colsel").append($colselbox).append($coldrop).append(selectInput);
		
		$(dataObj.Items).each(function(i,n){
			var $item=$(document.createElement("li"));
			if(n.topid==0){
				$coldrop.append($item);
				$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
			}else{
				if($("#col_"+ids+"_"+n.topid).find("ul").length<=0){
					$("#col_"+ids+"_"+n.topid).append("<ul class=\"dropmenu rootmenu\"></ul>");
					$("#col_"+ids+"_"+n.topid).find("ul:first").append($item);
					$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
				}else{
					$("#col_"+ids+"_"+n.topid).find("ul:first").append($item);
					$item.html("<span>"+n.name+"</span>").attr({"values":n.value,"id":"col_"+ids+"_"+n.colid});
				}
			}			
		});
		
		$this.find("li").each(function(){
			$(this).click(function(event){
				$colselbox.children("span").text($(this).find("span:first").text());
				$(selectInput).val($(this).attr("values"));
				hideMenu();
				event.stopPropagation();
			});
			if($(this).find("ul").length>0){
				$(this).addClass("menuout");
				$(this).hover(function(){
						$(this).removeClass("menuout");
						$(this).addClass("menuhover");
						$(this).find("ul:first").fadeIn("fast")
					},function(){
						$(this).removeClass("menuhover");
						$(this).addClass("menuout");
						$(this).find("ul").each(function(){
							$(this).fadeOut("fast");
					});
				});
			}else{
				$(this).addClass("norout");
				$(this).hover(function(){
					$(this).removeClass("norout");
					$(this).addClass("norhover");
					},function(){
					$(this).removeClass("norhover");
					$(this).addClass("norout");
				});
			}
		});
		
		function hideMenu(){
			$this.bOpen=0;
			$(".rootmenu").hide();
			$coldrop.slideUp("fast");
			$(document).unbind("click",hideMenu);
		}
		function openMenu(){
			$coldrop.slideDown("fast");
			$this.bOpen=1;
		}
		$colselbox.click(function(event){
      $(this).blur();
			if($this.bOpen){
				hideMenu();
			}else{
				openMenu();
				$(document).bind("click",hideMenu);
			}
			event.stopPropagation();
		});
		$(".rootmenu").each(function(){
			if($.browser.msie){
				$(this).css({"margin-top":"-6px","top":"auto"});
			}else{
				$(this).css({"margin-top":"-25px","top":"auto"});
			}
			$(this).css({"left":135+"px"});
		});	
	}
 })(jQuery);