$(document).ready(function(){
	//$("#tableClass tr").height(40);
	$.formValidator.initConfig({formID:"upload",theme:"ArrowSolidBox",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	}); 
	$("#type_id").formValidator({onShow:"请选择资讯栏目",onFocus:"资讯栏目必须选择",onCorrect:"谢谢你的配合",defaultValue:""}).inputValidator({min:1,onError: "你是不是忘记选择资讯栏目了!"}).defaultPassed();
	
	$("#title").formValidator({onShow:"请输入标题名称",onFocus:"标题名称2-150个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:150,onError:"你输入的标题名称为空或长度非法,请确认"}); 
	 
	$("#sort_order").formValidator({empty:true,onShow:"请输入的排序（0-1000岁之间）",onFocus:"只能输入0-1000之间的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:1000,type:"value",onErrorMin:"你输入的值必须大于等于1",onError:"排序必须在0-1000之间，请确认"}).defaultPassed();
	
	//$("#content").formValidator({onShow:"请输入内容",onFocus:"内容1个字符以上",onCorrect:"恭喜你,你输对了",defaultValue:" "}).inputValidator({min:1,onError:"你输入的内容长度为空或非法,请确认"});
	 
});