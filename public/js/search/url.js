/*返回当前搜素参数的url形式*/

//获取并重组所有参数
var ul;
var thisStat = 0;
function searchUrl(){
	//获取单项参数
	function get_SearchKey(key){
		var search_key='';
		$("#"+key).find("a.on").each(function(){
			if(search_key==''){
				search_key = search_key + $(this).attr("id");
			}else{
				search_key = search_key + "_" + $(this).attr("id");
			}
		});
		return search_key;
	}
	//处理参数返回方式
	function urlkey(key,val)
	{
		var keystr = '';
		if(thisStat == 0 ){
		   if(ul==''){ keystr = key + '='; } else { keystr = '&' + key + '='; }
		}else{
		   if(ul==''){ keystr = ''; } else { keystr = '-'; }
		}
		return ul + keystr + val;
	}
	
	//选择的城市
	var c_id = $(".city_select #title").find("a").attr("id");
	//不切换城市时,选择的地区
	var a_id = $(".city_select #areas").find("a.on").attr("id");
	//选择的类型(安装\装修\修缮)
	var classid = $("#classid").val();
	//获取关键词
	var keyword = $('#keyword').val();
	if( keyword==keyword_set ) keyword = '';
	//重组参数
	ul = '';
	ul = urlkey('c_id',c_id);
	ul = urlkey('a_id',a_id);
	ul = urlkey('classid',classid);
	//其他选项
	$('#search_keys').find('.click_box').each(function(){
		var thisid = $(this).attr('id');
		if(thisid!='' && thisid!=null && thisid!='undefined'){
			var thisval = get_SearchKey(thisid);
			if(thisval!='' && thisval!=null && thisval!='undefined'){
				ul = urlkey(thisid,thisval);
			}
		}								   
	});
	ul = urlkey('keyword', keyword );
	if( ul!='' ){
		if(thisStat == 0 ){ ul = '?' + ul; }else{ ul = '/search/s/' + ul; }
	}
	return ul;
}



//关联选择热门技能和，普通技能
function skills(ty){
	var classid = $(".click_box #classid").val();
	var industryid = get_SearchKey('industryid');
	var sUrl= "/search/app_skills/"+classid+"/"+industryid+"/";
	if(ty==1){
	  $("#hot_skills").load(sUrl+"/1",function(){});
	}else{
	  $("#skills").load(sUrl+"/0",function(){fitheight();});	 
	}
}

//展开隐藏工作项目自适应高度
function fitheight(){
	var lheight = 84;
	var boxheight = $("#skills").height();
    if(boxheight>12){
	   var name=navigator.appName;
	   if(name=="Microsoft Internet Explorer"){
		  boxheight=boxheight-0;
	   }
    }else{
	   boxheight = boxheight - 10;	 
    }
	
	var SB_obj = $("#skills_box");
	var isopen = SB_obj.attr("isopen");
	if(isopen=='1'){
		SB_obj.animate({"height":boxheight},200);
	}else{
		if(boxheight<lheight){
			SB_obj.animate({"height":boxheight},200);	
		}else{
			SB_obj.animate({"height":lheight},200);	
		}
	}
}

//收展技术栏  (全局 img_url) 
function updown(){
	var BSC_obj = $("#skills_box #btu_skill_change");
	var boxheight = $("#skills").height();
	var isopen = BSC_obj.parent().parent().attr("isopen");
	if(isopen=="1"){
	   BSC_obj.parent().parent().attr("isopen","0");
	   fitheight();
	   BSC_obj.attr('class','btu_skill_down');
	}else{
	   BSC_obj.parent().parent().attr("isopen","1");
       fitheight();
	   BSC_obj.attr('class','btu_skill_up');
	}
}

//绑定键盘事件(go)
var sUrl = '';
//shortcut.add("Enter",function(){window.location.href="?"+searchUrl();});
// 按下后，搜索内容