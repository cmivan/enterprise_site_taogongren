$(function(){
	//所有项的点击事件
	$(".click_box a").live("click",function(){
	   var isfor=$(this).parent().attr("isfor");
	   var thison=$(this).attr('class');
	   if(isfor=="1"){ //for 单选
			if(thison!='on'){
				$(this).parent().find("a").attr('class','');$(this).attr('class','on');
			}
	   }else{ //for 多选
			if(thison=='on'){
				$(this).attr('class','');
				//用于多选为空时不限 被选中
				var onid=$(this).parent().find("a.on").attr("id");
				if(onid==null){
					$(this).parent().find("a#no").attr('class','on');
				}
			}else{
				$(this).attr('class','on');
				//用于多选不为空时不限 不被选中
				$(this).parent().find("a#no").attr('class','');
			}
		}
	});
	//点击不限按钮时，清空其他选中项 for ie6
	$(".click_box").find("a#no").live("click",function(){
		$(this).parent().find("a").attr('class','');
		$(this).attr('class','on');
	});
});