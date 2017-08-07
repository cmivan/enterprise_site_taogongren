//评分
$(function(){
	var className;
	var classID;
	var dpText="";
	var dpTextC="";
	var onclass="";
	$(".pingji dt a").css({'cursor':'pointer'});
	$(".pingji dt a").bind("click",function(){
		className = "selectS" + $(this).attr("id");
		classID = $(this).parent().attr("id");
		$(this).parent().removeClass().addClass(className);
		dpTextC = $(this).attr("id");
		$(this).parent().find(".scor").html("<span class=chenghong2>"+dpTextC+"</span>分");
		return false;
	})	
	.bind("mouseover",function(){
							   $(this).parent().addClass("selectS" + $(this).attr("id"));
							   $(this).parent().find("input").val($(this).attr("id"));
							   })	
	.bind("mouseout",function(){
		$(this).parent().removeClass("selectS" + $(this).attr("id"));
		$(this).parent().find("input").val($(this).attr("id"));
		if($(this).parent().attr("id") == classID){
			$(this).parent().addClass(className);
			$(this).parent().find("input").val(dpTextC);
			}
	});
	//好中差
    $("input.hp").click(function(){ $("#haoping_scor").text($(this).val()); $("#hp_scor").val($(this).val()); });
	
	//提交评价
	$("#send_but").click(function(){
		$("#send_tip").text('loading...');
		var scor="";
		var scortip="";
		var scoryes=true;
		var cid=$("#cid").val();
		var haoping_scor=$("#haoping_scor").text();
		var note=$("#note").val();
		$(".scor").each(function(){
		if(scoryes){
		  var thisTxt=$(this).find("span").text();
		  if(thisTxt!=""&&thisTxt!=null){
			  scor=scor+","+$(this).attr("id")+"_"+thisTxt;
		  }else{
			  scortip="你还没给"+$(this).parent().parent().find("dd").text()+"!";
			  scoryes=false;
		  }}
		});
	});	
	
});