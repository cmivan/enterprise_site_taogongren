$(function(){
	//页面加载完成,技能框自适应高度
	fitheight();
		   
	//收展技术栏并记录状态	   
	$("#skills_box #btu_skill_change").click(function(){
		updown();
		var isopen=$("#skills_box").attr("isopen");
		if(isopen=="1"){isopen="1";}else{isopen="0";}
		$.get('/search/open/?isopen=' + isopen);
	});
	//设计师样式
	$("#industry").find("a#612").css({"color":"#F60"});

	//添加提示标签
	//$(".click_box").attr("title","  选择后，按下回车键(Enter)搜索!  ");
	//选择工种时触发
	$("#industryid a").live("click",function(){skills(0);skills(1);});
	//修改项目类型的时触发
	$(".click_box #classid").change(function(){skills(0);skills(1);});
	//点击搜索按钮的时候触发
	$(".search_but").live("click",function(){ window.location.href = searchUrl(); return false; });

    //初始化、绑定右边工人tab事件
	$(".recommendbox .tab_top").find("a").eq(0).attr("class","on");
	$(".recommendbox .tab_top").find("a").eq(2).attr("class","on");
	$(".recommendbox .tab_top").find("a").eq(4).attr("class","on");
	$(".recommendbox").find(".tab").eq(0).css({display:"block"});
	$(".recommendbox").find(".tab").eq(2).css({display:"block"});
	$(".recommendbox").find(".tab").eq(4).css({display:"block"});  
	$(".recommendbox .tab_top").find("a").hover(
		function(){
			var thisindex=$(this).index();
			$(this).parent().find("a").attr("class","");
			$(this).attr("class","on");
			$(this).parent().parent().find(".tab_box").find(".tab").css({display:"none"}).eq(thisindex).css({display:"block"});
		   },
		function(){}
		);							  

	//鼠标移到搜索筛选框上显示效果,背景变色并出现搜索按钮(9:46 2011-3-1)
	$(".search_left").find(".box li[sbut=yes]").hover(
		function(){
			$(this).attr("class","on");
			//创建按钮
			var num=$(this).find(".butsearch").length;
			if(num<=0){$(this).append('<span class="butsearch"><button id="btu_search_mini" class="cm_but search_but">&nbsp;</button></span>');}
			
			$(this).css({"position":"relative"});
			$(this).find(".butsearch").css({display:"block"});
			},
		function(){
			$(this).attr("class","").css({"position":""});
			//隐藏按钮
			$(this).find(".butsearch").css({display:"none"});
			}
		);
	
	//特殊按钮(21:15 2011-3-8)
	$(".search_left").find(".box li").eq(0).hover(
		function(){
			$(this).attr("class","on");
			//创建按钮
			var parObj=$(".search_left").find(".box li").eq(1);
			var num=parObj.find(".butsearch").length;
			if(num<=0){parObj.append('<span class="butsearch"><button id="btu_search_mini" class="cm_but search_but">&nbsp;</button></span>');}
			parObj.css({"position":"relative"});
			parObj.find(".butsearch").css({display:"block"});
			},
		function(){
			var parObj=$(".search_left").find(".box li").eq(1);
			parObj.attr("class","").css({"position":""});
			//隐藏按钮
			parObj.find(".butsearch").css({display:"none"});
			}
		);

//鼠标移到工人上显示效果,背景变色(9:46 2011-3-1)
//	$(".worker").find("table").hover(
//		function(){$(this).attr("class","on")},
//		function(){$(this).attr("class","")}
//		);
	
	//鼠标移到工人上显示效果,背景变色(9:46 2011-3-1)
	$(".worker").hover(
		function(){
			$(this).css({"margin-top":"-1px","border":"#000 1px solid","background-image":"url("+img_url+"search/bg.gif)"});
			//$(this).find("table").attr("class","on")
			},
		function(){
			$(this).css({"margin-top":"0","border":"#fff 1px solid","border-top":"0","border-bottom":"#CCC 1px dashed","background-image":"url('')"});
			//$(this).find("table").attr("class","")
			}
		);
	
});