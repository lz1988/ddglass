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