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
	$("#ztid").formValidator({onShow:"请选择活动专题",onFocus:"活动专题必须选择",onCorrect:"谢谢你的配合",defaultValue:""}).inputValidator({min:1,onError: "你是不是忘记选择活动专题了!"}).defaultPassed();
	
	$("#username").formValidator({onShow:"请输入中奖姓名",onFocus:"请输入中奖姓名",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:20,onError:"你输入的网站url为空或长度非法,请确认"});

	

	$("#memo").formValidator({onShow:"请输入中奖详情",onFocus:"中奖详情2-100个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:100,onError:"中奖详情长度非法,请确认"});

	
	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000之间数字）",onFocus:"只能输入0-10000之间数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于等于0",onError:"年龄必须在0-10000之间数字，请确认"}).defaultPassed();
	$("#tel").formValidator({empty:true,onShow:"请输入你的手机或电话，可以为空哦",onFocus:"格式例如：0577-88888888或11位手机号码",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留手机或电话了吗？"}).regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"你输入的手机或电话格式不正确"});
		
	
});