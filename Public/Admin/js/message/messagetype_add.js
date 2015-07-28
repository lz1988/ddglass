$(document).ready(function(){
	//$("#tableClass tr").height(40);
	$.formValidator.initConfig({formID:"form1",theme:"ArrowSolidBox",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	}); 
	$("#type_name").formValidator({onShow:"请输入栏目名称",onFocus:"栏目名称2-30个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:30,onError:"你输入的栏目名称长度非法,请确认"}); 
	$("#sort_order").formValidator({empty:true,onShow:"请输入的排序（0-1000岁之间）",onFocus:"只能输入0-1000之间的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:1000,type:"value",onErrorMin:"你输入的值必须大于等于1",onError:"排序必须在0-1000之间，请确认"}).defaultPassed();
});