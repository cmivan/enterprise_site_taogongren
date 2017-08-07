//展开隐藏工作项目自适应高度
function fitheight(){
	var lheight=84;
	var boxheight=$("#search_skills").height();
    if(boxheight>12){
	   var name=navigator.appName;
	   if(name=="Microsoft Internet Explorer"){
		  boxheight=boxheight-0;
	   }
    }else{
	   boxheight=boxheight-10;	 
    }
	
	var isopen=$("#skills_box").attr("isopen");
	if(isopen=="1"){
		$("#skills_box").animate({"height":boxheight},200);
	}else{
		if(boxheight<lheight){
			$("#skills_box").animate({"height":boxheight},200);	
		}else{
			$("#skills_box").animate({"height":lheight},200);	
		}
	}
}

//收展技术栏  (全局 img_url) 
function updown(){
	var boxheight=$("#search_skills").height();
	var isopen=$("#skills_box #btu_skill_change").parent().parent().attr("isopen");
	if(isopen=="1"){
	   $("#skills_box #btu_skill_change").parent().parent().attr("isopen","0");
	   fitheight();
	   $("#skills_box #btu_skill_change").attr('class','btu_skill_down');
	}else{
	   $("#skills_box #btu_skill_change").parent().parent().attr("isopen","1");
       fitheight();
	   $("#skills_box #btu_skill_change").attr('class','btu_skill_up');
	}
}

/* <><><><> 绑定键盘事件(go) <><><><> */
var sUrl="";
//shortcut.add("Enter",function(){window.location.href="?"+searchUrl();});
// 按下后，搜索内容