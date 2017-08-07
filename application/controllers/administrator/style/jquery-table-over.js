//定义鼠标移过样式
$(function(){
  $(".forumRow").hover(
		function(){$(this).find("td").css({"background-color":"#fff"});}
												   ,
		function(){$(this).find("td").css({"background-color":""});
		});
  
//全选或取消列表项
  $("#del_checkbox").click(function(){
	 var thischeck=$(this).attr("checked");
		 $(".del_id").attr("checked",thischeck);
	 });
  
  $("#Submit_delsel").click(function(){
	 if(ischecked()){
		if(confirm("确定要删除选中项?")){
			return true;
		}else{
			return false;	
		}
	 }else{
			return false;
		 }
	 });
  
					   
  
   });

/*判断是否选中项*/
function ischecked(){
	var thisis=false;
	$(".del_id").each(function(){
		if(thisis==false){
			var thischecked=$(this).attr("checked");
			if(thischecked){thisis=true;}
			}
		});
	if(thisis==false){alert("至少要选择一项!");	}
	return thisis;
	}