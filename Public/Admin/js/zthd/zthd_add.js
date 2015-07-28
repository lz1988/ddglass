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
	$("#name").formValidator({onShow:"请输入活动专题名称",onFocus:"活动专题名称4-50个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:4,max:50,onError:"你输入的活动专题名称为空或长度非法,请确认"});
	
	$("#url").formValidator({onShow:"请输入网站url",onFocus:"网站url如www.yezis.cn",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:5,max:80,onError:"你输入的网站url为空或长度非法,请确认"});
	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000之间数字）",onFocus:"只能输入0-10000之间数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于等于0",onError:"必须在0-10000之间数字，请确认"}).defaultPassed();

	$("#nums").formValidator({empty:true,onShow:"请输入的排序（0-100000之间数字）",onFocus:"只能输入0-10000之间数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:100000,type:"value",onErrorMin:"你输入的值必须大于等于等于0",onError:"必须在0-100000之间数字，请确认"}).defaultPassed();
	
	
});