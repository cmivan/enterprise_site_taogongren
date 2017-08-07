//返回当前搜素参数的url形式
//记录当前的城市
var on_c_id='';
//返回所选的说有内容
function searchkeys(){
		//选择的城市
		var c_id=$(".city_select #title").find("a").attr("id");
		    goUrl="c_id="+c_id;
		//不切换城市时,选择的地区
		var a_id=$(".city_select #areas").find("a.on").attr("id");
		    goUrl = goUrl+"&a_id="+a_id;
		//选择的类型(工人/团队)
		var search_usertype=$("#search_usertype").find("a.on").attr("id");
		    goUrl = goUrl+"&usertype="+search_usertype;
		//选择的工种
		var search_industry="";
	        $("#search_industry").find("a.on").each(function(){
		    if(search_industry==""){search_industry=search_industry+$(this).attr("id");}else{search_industry=search_industry+"_"+$(this).attr("id");
				}});
		    goUrl = goUrl+"&industry="+search_industry;
		//选择的类型(安装\装修\修缮)
		var classid=$("#classid").find("a.on").attr("id");
		    goUrl = goUrl+"&classid="+classid;
			
		if(goUrl!=""){goUrl = goUrl+"&keyword=";}
		goUrl = encodeURI(goUrl);
		return '?' + goUrl;
	}