var base_url=base_url;
if(base_url==''||base_url==null){base_url='/';}
var thiskeyword="";

$(function(){   
	//搜索框
	var keywordstr="请输入搜索内容...";
	if($("#searchbox #keyword").val()==""){
		$("#searchbox #keyword").val(keywordstr);
		$("#searchbox #keyword").css({"color":"#999"});
	}
	$("#searchbox #search_type").change(function(){$("#searchbox").attr("action",$(this).val());});
	$("#searchbox #keyword").blur(function(){
		var eraserid=$(".eraser").attr("id");
		if(eraserid!="y"){
			if($(this).val()==thiskeyword&&thiskeyword!=""){
			  //不存在橡皮擦
			  $(this).attr("readonly",true);
			  $(".submit").html('<a href="?keyword=" class="eraser" id="y"><img src="' + base_url + 'public/images/search_botton_eraser.gif" name="search_botton_eraser" width="28" height="28" id="search_botton_eraser" title="清除关键词，重新输入!" /></a>');
			}
		}else{
			if($(this).val()==""){$(this).val(keywordstr);$(this).css({"color":"#999"});} 
		}
	  });
   
	//点击搜索输入框则，搜索按钮
	$("#keyword").click(function(){
		if($(this).val()==keywordstr){$(this).val("");$(this).css({"color":""});}				
		var eraserid=$(".eraser").attr("id");
		if(eraserid=="y"){
		 //存在橡皮擦
		 $(this).attr("readonly",false);
		 $(this).focus();
		 $(this).select();
		 $(".submit").html('<button id="btu_search_change" class="btu_search tip" type="submit" title="我要找找!">&nbsp;</button>');
		}
	  });
   
	$("#searchbox #search_button").live("click",function(){							 
		  var keyword_val=$("#searchbox #keyword").val();
		  if($("#searchbox").attr("action")==""){
			  $("#searchbox .diy_select").fadeOut(0);
			  $("#searchbox .diy_select").fadeIn(300);
			  return false;
		  }else if(keyword_val==keywordstr){	
			  $("#searchbox #keyword").fadeOut(0);
			  $("#searchbox #keyword").fadeIn(300);
			  return false;
		  }
		});

	//搜索下拉
	$(".diy_select").mouseout(function(){$(".diy_select").find(".option").css({"display":"none"});});
	$(".diy_select .option").mouseover(function(){$(this).css({"display":"block"});});
	$(".diy_select .option").mouseout(function(){$(this).css({"display":"none"});});
	$(".diy_select").find(".title a").click(function(){$(this).parent().parent().find(".option").css({"display":"block"});});
	$(".diy_select").find(".option a").click(function(){
		  var s_id   =$(this).attr("id");
		  var s_title=$(this).text();
		  $(this).parent().parent().find("#search_type").val(s_id);
		  $("#searchbox").attr("action",s_id);
		  $(this).parent().parent().find(".title a").attr("id",s_id);
		  $(this).parent().parent().find(".title a").text(s_title);
		  $(this).parent().css({"display":"none"});
		  //清除橡皮檫 (2011-03-02)
		  $(".submit").html('<button id="btu_search_change" class="btu_search tip" type="submit" title="我要找找!">&nbsp;</button>');
		});
		
   });