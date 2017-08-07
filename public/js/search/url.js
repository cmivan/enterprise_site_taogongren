//返回当前搜素参数的url形式

//记录当前的城市
var on_cityid='';
//返回所选的说有内容
function searchUrl(){
		//选择的城市
		var citys=$(".city_select #title").find("a").attr("id");
			ul="cityid="+citys;
		//不切换城市时,选择的地区
		var areas=$(".city_select #areas").find("a.on").attr("id");
		   ul=ul+"&areaid="+areas;
		//选择的类型(工人/团队)
		var search_team_or_men=$("#search_team_or_men").find("a.on").attr("id");
			ul=ul+"&team_or_men="+search_team_or_men;
		//选择的工种
		var search_industry="";
	        $("#search_industry").find("a.on").each(function(){
		    if(search_industry==""){search_industry=search_industry+$(this).attr("id");}else{search_industry=search_industry+"_"+$(this).attr("id");
				}});
			ul=ul+"&industryid="+search_industry;
		//选择的类型(安装\装修\修缮)
		var classid=$("#classid").val();
		    ul=ul+"&classid="+classid;
		//选择的热门工作项目
		var hot_search_skills="";
	        $("#hot_search_skills").find("a.on").each(function(){
	        if(hot_search_skills==""){hot_search_skills=hot_search_skills+$(this).attr("id");}else{hot_search_skills=hot_search_skills+"_"+$(this).attr("id");
				}});
		    ul=ul+"&hot_skills="+hot_search_skills;
		//选择的工作项目
		var search_skills="";
	        $("#search_skills").find("a.on").each(function(){
	        if(search_skills==""){search_skills=search_skills+$(this).attr("id");}else{search_skills=search_skills+"_"+$(this).attr("id");
				}});
		    ul=ul+"&skills="+search_skills;
		//选择的等级
		var search_level=$("#search_level").find("a.on").attr("id");
            ul=ul+"&level="+search_level;
		//选择的年限
		var search_age=$("#search_age").find("a.on").attr("id");
            ul=ul+"&age="+search_age;
		//选择的认证
		var search_approve="";
	        $("#search_approve").find("a.on").each(function(){
	        if(search_approve==""){search_approve=search_approve+$(this).attr("id");}else{search_approve=search_approve+"_"+$(this).attr("id");
				}});
            ul=ul+"&approve="+search_approve;
			
			if(ul!=""){ul=ul+"&keyword=";}
			
		return ul;
	}