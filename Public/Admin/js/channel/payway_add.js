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
	$("#payway_name").formValidator({onShow:"请输入支付名称称",onFocus:"支付名称4-25个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:4,max:50,onError:"你输入的支付名称为空或长度非法,请确认"}); 
	 
		$("#type_id").formValidator({onShow:"请选择支付通道",onFocus:"支付通道必须选择",onCorrect:"谢谢你的配合",defaultValue:""}).inputValidator({min:1,onError: "你是不是忘记选择支付通道了!"}).defaultPassed();
 
	//$("#code").formValidator({empty:true,onShow:"请输入支付编码",onFocus:"支付编码1-100个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:100,onError:"你输入的支付编码为空或长度非法,请确认"});
	
	$("#rate").formValidator({onShow:"请输入的兑换比率（大于0的数字）",onFocus:"只能输入大于0的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:1000000,type:"value",onErrorMin:"你输入的值必须大于等于0",onError:"排序必须大于0的数字，请确认"}).defaultPassed();
	
	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000岁之间）",onFocus:"只能输入0-10000之间的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于1",onError:"排序必须在0-10000之间，请确认"}).defaultPassed();
});