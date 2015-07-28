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
	$("#title").formValidator({onShow:"请输入广告标题",onFocus:"广告标题1-30个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:30,onError:"你输入的广告标题为空或长度非法,请确认"});
	
	$("#type_id").formValidator({onShow:"请选择广告组",onFocus:"广告组必须选择",onCorrect:"谢谢你的配合",defaultValue:""}).inputValidator({min:1,onError: "你是不是忘记选择广告组了!"}).defaultPassed();
	
	//$("#small_icon").formValidator({onShow:"请上传缩略图",onFocus:"缩略图必须上传",onCorrect:"恭喜你,上传成功",defaultValue:""}).inputValidator({min:5,max:40,onError:"你还没有上传缩略图,请确认"});
	
	//$("#large_icon").formValidator({onShow:"请上传大图",onFocus:"大图必须上传",onCorrect:"恭喜你,上传成功",defaultValue:""}).inputValidator({min:5,max:40,onError:"你还没有上传大图,请确认"});
	
	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000岁之间）",onFocus:"只能输入0-10000之间的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于1",onError:"排序必须在0-10000之间，请确认"}).defaultPassed();
});