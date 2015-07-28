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
	$("#link_name").formValidator({onShow:"请输入网站名称",onFocus:"网站名称1-20个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:1,max:20,onError:"你输入的网站名称为空或长度非法,请确认"});
	
	$("#link_url").formValidator({onShow:"请输入网站url",onFocus:"网站url如www.yezis.cn",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:5,max:80,onError:"你输入的网站url为空或长度非法,请确认"});
	
	$("#ads_name").formValidator({empty:true,onShow:"请输入站长名称",onFocus:"站长名称2-10个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:10,onError:"你输入的站长名称长度非法,请确认"});
	
	$("#email").formValidator({empty:true,onShow:"请输入邮箱",onFocus:"邮箱6-100个字符,输入正确了才能离开焦点",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:6,max:100,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"你输入的邮箱格式不正确"});
	
	$("#phone").formValidator({empty:true,onShow:"请输入你的手机或电话，可以为空哦",onFocus:"格式例如：0577-88888888或11位手机号码",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留手机或电话了吗？"}).regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"你输入的手机或电话格式不正确"});
	
	$("#sort").formValidator({empty:true,onShow:"请输入的排序（0-10000之间数字）",onFocus:"只能输入0-10000之间数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:0,max:10000,type:"value",onErrorMin:"你输入的值必须大于等于等于0",onError:"年龄必须在0-10000之间数字，请确认"}).defaultPassed();
	
});