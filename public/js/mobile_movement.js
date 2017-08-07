//动画显示手机号码
function sc_box(sj,gid){
	//定义最终大小
	var t_width ="75px";
	var t_height="16px";
	//获取当前框的大小
    var h="180px";
	//var h=$("#TB_window").css("height");
    var w=$("#TB_window").css("width");
    var TB_w=$("#TB_window").offset();
    var l=TB_w.left;
	var t=TB_w.top;

	$("#TB_window").css({"display":"none"});
	$("#TB_window").css({"display":"none"});
    //创建新的框
    var sboxsize=$("#showbox").size();
    if(sboxsize<=0){$('body').append("<div id='showbox'>&nbsp;</div>");}
    $("#showbox").css({"height":h,"width":w,"left":l,"top":t,"border":"#F60 6px solid","position":"absolute","z-index":"999","display":"block"});

    if(gid!=parseInt(gid)){ gid=1; }
	//根据gid获取被操作的对象
	var sbox=$("[gid='"+gid+"']").offset();
	var t_left=sbox.left;
	var t_top =sbox.top;

	//动画到指定位置
    $("#showbox").animate(
			{top:t_top,left:t_left,width:t_width,height:t_height,opacity:0},
			{duration:800,complete:function(){
				$("#showbox").css({"display":"none"});
				if(sj!=""){
					$(".get_mobile").html("<span>"+sj+"</span>");
					$(".get_mobile").attr("class","get_mobile_ok tip");
					$(".twitter").remove();
					$(".get_mobile_ok").attr("title","已付费!");
					bindtip(); //重新绑定tip提示
					$(".get_mobile_ok").fadeOut(100).fadeIn(600);
					}
			}}
			);
	}