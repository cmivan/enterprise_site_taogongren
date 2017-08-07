//var base_url=base_url;
if(base_url==''||base_url==null){base_url='/';}
$(function(){
	/*弹出框关闭按钮2(带渐变效果)*/
   $("#TB_close").live("click",function(){Tbox_close();});
	/*登录框*/
   $(".user_login").click(function(){ box_login(); });
	/*意见反馈*/
   $(".user_feedback").live("click",function(){ box_feedback(); });
	/*联系我们*/
   $(".contact").click(function(){ box_contact(); });
	/*退出管理*/
   $(".user_login_out").click(function(){if(confirm('确定退出管理?')){return true;}else{return false;}});
	/*收藏本站*/
   $(".favorite").click(function(){ window.location.href = base_url + "page/favicon";});
   //绑定收藏按钮
   $("a.yz_favorites").click(function(){ JsonTo($(this),'favorite'); });
   $(".favorites").find("a").live("click",function(){ JsonTo($(this),'favorite'); });
   //绑定雇佣按钮
   $("a.yz_buy").click(function(){ JsonTo($(this),'orderto'); });
   $(".order").find("a").click(function(){ JsonTo($(this),'orderto'); });
   //发送信息
   $(".send_msg").click(function(){ JsonTo($(this),'send_msg'); });
   //绑定加好友按钮
   $("a.yz_friend").click(function(){ JsonTo($(this),'friend'); });
   //查看手机
   $(".get_mobile").live("click",function(){
		var uid=$(this).parents().attr("userid");
		var gid=$(this).parents().attr("gid");
		if(uid==parseInt(uid)){ JsonAction('action/get_mobile/'+uid+'?gid='+gid); }
		});
   //参与投标
   $("#retrieval_join").click(function(){
		var rid=$(this).attr("retrievalid");
		if(rid==parseInt(rid)){ JsonAction('retrieval/joins?id='+rid);}
		});
   //用户登录
   $("#login_btu").live("click",function(){
	   var u_name=$(this).parents().find("#username").val();
	   var p_word=$(this).parents().find("#password").val();
	   if(u_name==""){
		  alert("请填写登录帐号!");
		  $(this).parent().parent().parent().find("#username").fadeOut(200).fadeIn(200); return false;
	   }else if(p_word==""){
		  alert("请填写登录密码!");
		  $(this).parent().parent().parent().find("#password").fadeOut(200).fadeIn(200); return false;
	   }else{
		  //提交
		  $.ajax({
			  url:base_url+'action/login',
			  type:'post',dataType:'json', data: 'username='+u_name+'&password='+p_word,
			  success:function(j){ alert(j.info); if(j.cmd=="y"){ window.location.reload(); }
			  }});
		  return false;
	   } 
	 });


   /*
    * 获取用户手机号码
    * */
   $("#GM_btu").live("click",function(){
	   var thisID =$("#thisID").val();
	   var gid=$("#thisGID").val();
	   if(thisID!=""&&thisID!=null){
		   $.ajax({
			   url:base_url+'action/get_mobile_go/'+thisID+'/'+gid,
			   type:'get',dataType:'json',
			   success:function(j){
				   if(j.cmd=="ok"){ sc_box(j.info,j.gid);tb_remove(); }
				   else{ alert(j.info);Tbox_close(); }
				}
			});
	        return false;
	   }else{
			Tbox_close();
			return false;
	   } 
   });

});

//@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---
//<><>---<><><><>---<><><><>---<><><><>---<><><><>---<><><><>---<><>
//@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---@@@---

//弹出框关闭函数(带渐变效果)
function Tbox_close()
{
	$("#TB_window").fadeOut(0,function(){tb_remove();});
}

//用于站内消息、收藏、下单加好友等操作
function JsonTo(Obj,name)
{
	var uid = Obj.parents().attr("userid");
	if(uid!=parseInt(uid)){ uid=Obj.parents().parents().attr("userid"); }
    if(uid!=""){ JsonAction('action/'+name+'/'+uid); }
}

//obj 表示被操作对象,url 数据源
function JsonAction(url)
{
	var url1,url2,urls;
	url1 = 'cmjson' + base_url;
	url2 = 'cmjson' + url;
	var num = url2.indexOf(url1);
	if(num>=0){ urls = url; }else{ urls = base_url+url; }
	//提交并返回数据
	$.ajax({
	   url:urls,type:'GET',dataType:'json',
	   success:function(J){
		 switch(J.cmd)
		 {
			 //显示消息框
			 case "box": tb_show(J.title,J.url,false); break;
			 //跳转链接
			 case "url": window.location.href=J.url; break;
			 //弹出提示
			 case "alt": alert(J.info); break;
			 //{显示提示消息框}
			 case "g":
				show_getmobile(J.gid); break;
			 //{<活动>创建团队赠送提示}
			 case "activity.ok":
				$('.mainbox_box .tipbox').fadeOut(500,function(){alert(J.info);}); break; 
			 default:
		 }}
	 });
}

//显示手机框
function show_getmobile(gid)
{
   //页面uid
   var uid=$(".uid").attr("uid");
   if(uid==parseInt(uid)){
	   box_gemobile(uid,gid)
   }else{
	   alert('未能正确获取用户信息!','错误提示：');
   }
}
