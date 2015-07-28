 /* CSS背景控制 鼠标经过效果 */
function overColor(Obj) {
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback_o"
		Obj.bgColor="";
	}
	
}

/* 鼠标离开效果 */
function outColor(Obj){
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback";
		Obj.bgColor="";
	}
}

function check_all(id){
   obj = document.getElementsByName(id+"[]");
	  for( i=0; i<obj.length; i++)
	  {
	  	obj[i].checked = obj[i].checked ? false : true;
	  }     
}

function check_from(type,url){ 
	if (confirm("您确定要"+type+"所选记录吗？")){
		document.orgtype.action=url; 
		document.orgtype.submit(); 
	}
}

function sub_from(type,url){
	document.orgtype.action=url; 
	document.orgtype.submit(); 
}