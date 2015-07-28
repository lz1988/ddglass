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
	$("#type_name").formValidator({onShow:"请输入广告组名",onFocus:"广告组名1-30个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:30,onError:"你输入的广告组名为空或长度非法,请确认"});
	 
});