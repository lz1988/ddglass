
//
////*检查帐号**
//function check_account(){
//	var acc=$('#account').val();
//	if($.trim(acc)==""){
//   	    	$('#account_note').html('*帐号不能为空');
//   	        return false;
//    } 
//	if(acc.length<4 || acc.length>16){
//		$('#account_note').html('*(长度为4-16个字母、数字)');
//		return false;
//	}
//}
//
//function check_from(){
//	
//}
 
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
	
	$("#account").formValidator({onShow:"请输入用户名,只有输入\"maodong\"才是对的",onFocus:"用户名至少4个字符,最多16个字符",onCorrect:"该用户名可以注册"}).inputValidator({min:4,max:16,onError:"你输入的用户名为空或非法,请确认"}).ajaxValidator({
		dataType : "html",
		async : true,
		url : check_url,
		success : function(data){
			if(data==0){ 
		    	return true;
			}else{
				return false;
			} 
		},
		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onError : "该用户名不可用，请更换用户名",
		onWait : "正在对用户名进行合法性校验，请稍候..."
	}).defaultPassed();
	
	$("#email").formValidator({empty:true,onShow:"请输入邮箱",onFocus:"邮箱6-100个字符,输入正确了才能离开焦点",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:6,max:100,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({regExp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onError:"你输入的邮箱格式不正确"});
	
	if(jstype!="edit"){
		$("#password").formValidator({onShow:"请输入密码",onFocus:"至少1个长度",onCorrect:"密码合法"}).inputValidator({min:6,max:16,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码不能为空,请确认"});
		$("#rpassword").formValidator({onShow:"输再次输入密码",onFocus:"至少1个长度",onCorrect:"密码一致"}).inputValidator({min:1,empty:{leftEmpty:false,rightEmpty:false,emptyError:"重复密码两边不能有空符号"},onError:"重复密码不能为空,请确认"}).compareValidator({desID:"password",operateor:"=",onError:"2次密码不一致,请确认"});
	}else{
		$("#password").formValidator({empty:true,onShow:"请输入密码",onFocus:"至少1个长度",onCorrect:"密码合法"}).inputValidator({min:1,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码不能为空,请确认"});
		$("#rpassword").formValidator({onCorrect:"密码一致"}).compareValidator({desID:"password",operateor:"=",onError:"2次密码不一致,请确认"});
	}
	
	$("#true_name").formValidator({empty:true,onShow:"请输入真实姓名",onFocus:"真实姓名2-5个汉字",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:4,max:10,onError:"你输入的真实姓名长度非法,请确认"});
	
	$("#identity").formValidator({empty:true,ajax:true,onShow:"请输入15或18位的身份证",onFocus:"输入15或18位的身份证",onCorrect:"输入正确"}).functionValidator({fun:isCardID});
	
	$("#nick_name").formValidator({empty:true,onShow:"请输入昵称",onFocus:"昵称2-10个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:5,onError:"你输入的昵称长度非法,请确认"});
	
	$("#address").formValidator({empty:true,onShow:"请输入通讯地址",onFocus:"通讯地址5-100个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:5,onError:"你输入的通讯地址长度非法,请确认"});
	
	$("#phone").formValidator({empty:true,onShow:"请输入你的手机或电话，可以为空哦",onFocus:"格式例如：0577-88888888或11位手机号码",onCorrect:"谢谢你的合作",onEmpty:"你真的不想留手机或电话了吗？"}).regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"你输入的手机或电话格式不正确"});
	
	$("#qq").formValidator({empty:true,onShow:"请输入的qq（4-12位之间）",onFocus:"只能输入4-12位之间的数字哦",onCorrect:"恭喜你,你输对了"}).inputValidator({min:1000,max:100000000000,type:"value",onErrorMin:"你输入的值必须大于等于1",onError:"年龄必须在4-12位之间，请确认"}).defaultPassed();
	
	//$("#question").formValidator({empty:true,onShow:"请输入密保问题",onFocus:"密保问题2-20个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:5,onError:"你输入的密保问题长度非法,请确认"});
	
	//$("#answer").formValidator({empty:true,onShow:"请输入密保答案",onFocus:"密保答案2-20个字符",onCorrect:"恭喜你,你输对了",defaultValue:""}).inputValidator({min:2,max:5,onError:"你输入的密保答案长度非法,请确认"});
	
	
});