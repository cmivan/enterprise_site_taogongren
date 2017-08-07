$(function(){
    //所有项的点击事件
	$(".click_box a").live("click",function(){
	   var isfor=$(this).parent().attr("isfor");
	   var thison=$(this).attr("class");
	   if(isfor=="1"){
		  //for 单选
		  if(thison!="on"){$(this).parent().find("a").attr("class","");$(this).attr("class","on");}
		  window.location.href='?'+searchkeys();//转向页面
		  return false;
	   }else{
		  //for 多选
		  if(thison=="on"){
			  $(this).attr("class","");
			  $(this).find("input").attr("checked","");
		  }else{
			  $(this).attr("class","on");
			  $(this).find("input").attr("checked","checked");
		  }}
		});
	
	//鼠标经过信息项是 显示
	$("#retrieval_box").find("tr.out").hover(
	    function(){$(this).attr("class","over");},
		function(){$(this).attr("class","out");}
		);
	
	//鼠标经下拉选择时样式转换
	$(".selectbox").hover(
		function(){
			$(this).find(".click_box").css("display","block");
			$(this).find(".title_main font").html("&#53;");
			},
		function(){
			$(this).find(".click_box").css("display","none");
			$(this).find(".title_main font").html("&#54;");
			}
		);
 
 
	//鼠标移出工种选择框时
	$("#search_industry").hover(
	     function(){$("#SelectIDS").val(searchkeys());},								   
		 function(){
			 var thisSelectIDS=$("#SelectIDS").val();
			 var goUrl=searchkeys();
			 if(goUrl!=thisSelectIDS){
				 window.location.href='?'+searchkeys();//转向页面
				 return false;}
			 });

 
 });