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
	$("#role_name").formValidator({onShow:"请输入角色名称",onFocus:"角色名称4-20个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:4,max:20,onError:"你输入的角色名称为空或长度非法,请确认"});
});