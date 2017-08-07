//定义鼠标移过样式
$(function(){
  $(".forumRow").hover(
		function(){$(this).find("td").css({"background-color":"#fff"});}									   ,
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
//删除单项
  $(".delete").click(function(){
	 var url = $(this).attr("url");
	 var title = $(this).attr("title");
	 if(confirm('确定要删除【'+title+'】吗？\r\n删除后不可恢复!')){
		 window.location.href = url;
	 }else{
		 return false;
	 }
  });
//进入编辑
  $(".update").click(function(){
	 window.location.href = $(this).attr("url");
	 });
	 
  $("#edit_back").click(function(){
	  history.back(1);
	 });
  
//退出管理
  $(".login_out").click(function(){
	   if(confirm('确定已经编辑好并退出后台吗？')){
		   $(this).attr("href",$(this).attr("url"));
		   return true;
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
	

/*辅助函数，防止 mod_validform.js 提示错误*/
function bindtip(){return true;}