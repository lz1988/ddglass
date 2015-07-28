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
	$("#module_name").formValidator({onShow:"请输入网站名称",onFocus:"网站名称1-20个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:4,max:50,onError:"你输入的网站名称为空或长度非法,请确认"});
	$("#ztid").formValidator({onShow:"请选择活动专题",onFocus:"活动专题必须选择",onCorrect:"谢谢你的配合",defaultValue:""}).inputValidator({min:1,onError: "你是不是忘记选择活动专题了!"}).defaultPassed();

	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000之间数字）",onFocus:"只能输入0-10000之间数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于等于0",onError:"年龄必须在0-10000之间数字，请确认"}).defaultPassed();
	
});