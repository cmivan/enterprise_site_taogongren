$(function(){
	$("#index_fabu_bu").hover(
		function(){$(this).attr("class","on");},
		function(){$(this).attr("class","");}
	);
	for(i=0;i<=9;i++){ShowSkillBox(i,"block");}
	$(".news_index_skills .listbox").each(function(){
			var thisList=$(this).find(".list").eq(0);
			if(thisList.size()>0){
			   thisList.css({"display":"block"});
			   var l_y=$(this).height();
			   $(this).css({"height":l_y});
			   thisList.css({"position":"absolute"});
			}
			var thisClass=$(this).find(".selclass");
			if($(this).find(".selclass").size()>0){
			   var l_y=$(this).height();
			   $(this).css({"height":l_y});
			   thisClass.css({"position":"absolute"});
			   $(this).find(".selclass").find("a").attr("class","");
			   $(this).find(".selclass").find("a").eq(0).attr("class","on");
			}
			$(this).css({"position":"relative"});
		});
	$(".select .selclass a").click(function(){
			$(this).parent().find("a").attr("class","");
			$(this).attr("class","on");
			var index=$(this).index();
			var pars =$(this).parent().parent().parent().parent().parent().find(".list");
			pars.css({"display":"none"});
			pars.eq(index).css({"display":"block"});
			pars.css({"position":"absolute"});
			});
	$(".news_index_skills").hover(
			function(){$(this).css({"display":"block"});},
			function(){$(this).css({"display":"none"});}
			);
	$("area").hover(
		function(){
			var id=$(this).attr("id"); ShowSkillBox(id,"block");},
		function(){
			var id=$(this).attr("id"); ShowSkillBox(id,"none");}
		);
	for(i=0;i<=9;i++){ ShowSkillBox(i,"none"); }
	});

function ShowSkillBox(id,s){
	if(s=="none"||s=="block"){
	   $("#skill_i_"+id).css({"display":s});
	}else if(s==0){
	   $("#skill_i_"+id).fadeOut(200);
	}else if(s==1){
	   $("#skill_i_"+id).fadeIn(200);
	}
	SetSkillBox(id);
}
function SetSkillBox(id){
	var top;
	var left;
	var width;
	if(id==0){
	   top=235;left=130;//木工
	}else if(id==1){
	   top=215;left=-80; //电工
	}else if(id==2){
	   top=150;left=10;//油漆工
	}else if(id==3){
	   top=215;left=110;//泥工
	}else if(id==4){
	   top=150;left=-45;//水工
	}else if(id==5){
	   top=315;left=-15;//杂工
	}else if(id==6){
	   top=200;left=0; //扇灰
	}else if(id==7){
	   top=315;left=-100; //保洁
	}else if(id==8){
	   top=150;left=110;//设计师
	}else if(id==9){
	   top=315;left=0;//监理
	}
	width =258;
	$("#skill_i_"+id).css({"width":width+"px","top":top+"px","left":left+"px"});
}