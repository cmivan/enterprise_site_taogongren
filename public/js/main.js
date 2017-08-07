//var base_url=base_url;
if(base_url==''||base_url==null){base_url='/';}

/**
 * -----------------------
 * 搜索框配置信息
 * -----------------------
 */ 
var keyword_set = '请输入搜索内容...';
$(function(){	   
	//基本信息
	var keyword_obj = $("#searchbox #keyword");
	var keyword_now = keyword_obj.val();
	if( keyword_now == '' ){ keyword_obj.val( keyword_set ).css({'color':'#999'}); }
	//点击搜索输入框
	keyword_obj
	.click(function(){ if( $(this).val() == keyword_set ){ $(this).val('').css({'color':''}); } })
	.blur(function(){ if( $(this).val() == '' ){ $(this).val( keyword_set ).css({'color':'#999'}); } })
	.keyup(function(){
		var e_cmd = $("#eraser").attr("cmd");
		if(e_cmd=='y'){
			if( $(this).val() != keyword_now && keyword_now != ''){
				$(".submit").find('a').css({'display':'none'});
				$(".submit").find('button').css({'display':'block'});
			}else{
				$(".submit").find('a').css({'display':'block'});
				$(".submit").find('button').css({'display':'none'});
			}
		}
	});
	//点击搜索
	$("#searchbox #btu_search_change").click(function(){
		if($("#searchbox").attr("action")==''){
			$("#searchbox .diy_select").css({'display':'block'}); return false;
		}else if( keyword_obj.val() == keyword_set ){	
			keyword_obj.css({'display':'block'}); return false;
		}
	});
	//切换搜索类型
	$("#searchbox #search_type").change(function(){ $("#searchbox").attr("action",$(this).val()); });
	//搜索下拉
	$(".diy_select .option")
	.mouseover(function(){$(this).css({"display":"block"});})
	.mouseout(function(){$(this).css({"display":"none"});});
	
	$(".diy_select").mouseout(function(){$(".diy_select").find(".option").css({"display":"none"});});
	$(".diy_select").find(".title a").click(function(){$(this).parent().parent().find(".option").css({"display":"block"});});
	$(".diy_select").find(".option a").click(function(){
		  var s_id = $(this).attr("id");
		  var s_title = $(this).text();
		  $("#searchbox").attr("action",s_id);
		  $(this).parent().parent().find("#search_type").val(s_id);
		  $(this).parent().parent().find(".title a").attr("id",s_id).text(s_title);
		  $(this).parent().css({"display":"none"});
		  //清除橡皮檫 (2011-03-02)
		  $(".submit").find('a').css({'display':'none'});
		  $(".submit").find('button').css({'display':'block'});
	});
});