<?php $this->load->view('public/header');?>
<?php /*?>评级打分<?php */?>
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo $css_url?>mod_star.css" /><?php */?>
<?php /*?>排期日历<?php */?>
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo $js_url?>fullcalendar/fullcalendar.css" /><?php */?>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/prototype.js"></script>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/lightbox.js"></script>
<script type="text/javascript" src="<?php echo $js_url?>fullcalendar/fullcalendar.min.js"></script>
<?php /*?><script type="text/javascript" src="<?php echo $js_url?>jquery-ui-1.8.6.custom.min.js"></script><?php */?>
<script type='text/javascript'>
$(function(){
var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();
$('#calendar').fullCalendar({editable: false,events: [
<?php if(!empty($listing)){
  foreach($listing as $rs){?>
  {title:"<?php echo $rs->note?>",start:new Date(parseInt(<?php echo date("Y",strtotime($rs->mytime))?>), parseInt(<?php echo date("m",strtotime($rs->mytime))?>)-1, parseInt(<?php echo date("d",strtotime($rs->mytime))?>))},
<?php }}?>
    {title:"",start:new Date(parseInt(1800), parseInt(01), parseInt(01))}
  ]});
<?php /*?>点击排期按钮重新绑定标签<?php */?>
$(".fc-button-prev").live("click",function(){bindtip();});
$(".fc-button-next").live("click",function(){bindtip();});
$(".fc-button-today").live("click",function(){bindtip();});
});
</script>
<?php /*?><script type="text/javascript" src="<?php echo $js_url?>mod_poshytip.js"></script><?php */?>
<?php /*?>LightBox v2.0
<link rel="stylesheet" href="<?php echo $css_url?>screen.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>mod_lightbox.css" media="screen" />
<?php */?>
<script type="text/javascript">
<?php /*?>切换城市辅助<?php */?>
function searchkeys(){return false;}
$(function(){
  <?php /*?>初始化。选中第一项<?php */?>
  $(".content_tab").find(".tab_nav").find("li").eq(1).attr("class","on");
  $(".content_tab").find(".content").find("div.tab_item").css({display:"none"});
  $(".content_tab").find(".content").find("div.tab_item").eq(1).css({display:"block"});
  $(".content_tab").find(".tab_nav").find("li").click(
  function(){
	var TIndex=$(".content_tab").find(".tab_nav").find("li").index(this);
	$(".content_tab").find(".tab_nav").find("li").attr("class","");
	$(this).attr("class","on");
	$(".content_tab").find(".content").find("div.tab_item").css({display:"none"});
	$(".content_tab").find(".content").find("div.tab_item").eq(TIndex).css({display:"block"});
  });
  <?php /*?>table 间隔颜色<?php */?>
  $(".ltable tr").attr("bgColor","#fcfeee");
  $(".ltable tr:even").css("background-color","#fcf9e8");
  <?php /*?>手机提示框<?php */?>
  $(".mobile").hover(
  function(){
	var TipStr =$(this).find("a").attr("title"); var NoteStr=$(this).find(".note").text();
	if(TipStr!=""&&TipStr!=null&&NoteStr==""){$(this).find("a").attr("title","");$(this).find(".note").html(TipStr);}
	$(".mobile_tip").css({"display":"block"});
	},function(){$(".mobile_tip").css({"display":"none"});}
  );
<?php
//评级
if(!empty($rating_class)){
foreach($rating_class as $rs){
echo '$(".pingji dt#dpStar'.$rs->id.'").removeClass().addClass("selectS'.$this->Common_Model->rating_sroc($user->id,$rs->id).'");';
}}
?>
});
</script>
 
</head><body><?php $this->load->view('public/top');?><div class="main_width"><div class="body_main"><div class="body_left"><div class="content_box"><div class="content"><div class="info_top uid" uid="<?php echo $user->id?>"><div class="left"><a href="<?php echo site_url("user/".$user->id)?>"><img src="<?php echo $this->User_Model->faceB($user->photoID)?>" width="95" height="122" /></a></div><div class="right"><!--<div class="name"><?php echo $user->name?></div>--><div><span class="maintitle">队名</span>：<?php echo $user->name?></div><div><?php echo $user->c_name?>&nbsp;<?php echo $user->a_name?></div><div><span>等级：<button id="ico_levels" class="level_<?php echo $level;?>">&nbsp;</button></span></div><div><span class="haoping">好评率：<?php echo $haoping_sroc?></span></div>
 <div id="team_buttom"><div class="team_tilte"><img src="<?php echo $img_url?>ico/cilun.gif" align="absmiddle" />&nbsp;<?php echo $nicetitle?>的团队 <button id="btu_team_arrow" class="btu_team_arrow_down">&nbsp;</button></div><div class="team_box"><img src="<?php echo $img_url?>ico/development.png" align="absmiddle" />&nbsp;<?php if($is_teamer==false){?><a target="_blank" class="shenqing" href="javascript:void(0);" id="<?php echo $uid?>">申请加入</a><?php }else{?>共有<?php echo $team_num?>位成员<?php }?></div></div></div><div class="clear"></div></div>
<div class="info_edit"><div class="left"><?php echo $approves;?></div><div class="right" userid="<?php echo $user->id?>"><a href="javascript:void(0);" class="tip yz_buy" title="下单给他">&nbsp;</a><a href="javascript:void(0);" class="tip yz_favorites" title="放入收藏夹">&nbsp;</a><a href="javascript:void(0);" class="tip yz_friend" title="加他为好友">&nbsp;</a><a href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes" class="tip yz_qq" title="和他QQ交谈">&nbsp;</a><a href="javascript:void(0);" class="tip send_msg" title="发送站内消息">&nbsp;</a></div><div class="clear"></div></div><div class="clear"></div></div></div>
<div class="content_box"><div class="title" style="height:48px;"><li>累积信用金：<?php echo $credits?> <img src="<?php echo $img_url?>ico/gold.gif" width="13" height="15" align="absmiddle" /></li><li>总计收入：<?php echo $balances?> </li><li>揽活次数：<?php echo $jobtimes?> 次</li><li>从业时间：<?php echo $this->User_Model->entry($user->entry_age)?></li><div class="clear"></div></div>
 <div class="content" style="position:relative;"><div class="pingji"><?php
if(!empty($rating_class)){
   foreach($rating_class as $rs){
?><li><dd><?php echo $rs->title?></dd><dt id="dpStar<?php echo $rs->id?>"><?php for($i=1;$i<=5;$i++){?><a id="<?php echo $i?>">&nbsp;</a><?php }?><a class="scor"></a></dt></li><?php }}?>
</div><div class="clear"></div></div></div><div class="content_box"><div class="title"><h1>团队能手</h1><div class="clear"></div></div><div class="content"><div class="friends"><?php if(!empty($friend1)){?><?php foreach($friend1 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->fuid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->fuid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }}else{ echo '<div></div>'; }?>
<?php if(!empty($friend2)){?><?php foreach($friend2 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->uid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->uid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }}else{ echo '<div>&nbsp;</div>'; }?>
<div class="clear"></div><?php /*?><div style="position:relative;"><div class="more"><a href="javascript:void(0);">更多<img src="<?php echo $img_url?>ico/down.gif" width="15" height="16" align="absmiddle" /></a></div></div><?php */?></div><div class="clear"></div></div></div></div>
<div class="body_right"><div class="content_box"><div class="title"><h1>团队简介</h1><span>已有<em><?php echo $user->visited?></em>人浏览</span><div class="clear"></div></div><div class="content"><div style="padding:6px;"><div style="color:#000; font-size:14px; font-weight:bold"><?php echo $user->name?></div><?php echo $user->note?></div></div></div><div class="content_tab"><div class="top"></div><div class="box"><div class="tab_nav"><li><a href="javascript:void(0);">业主评价</a></li><li><a href="javascript:void(0);">服务项目</a></li><li><a href="javascript:void(0);">服务地区</a></li><li><a href="javascript:void(0);">参考报价</a></li><li><a href="javascript:void(0);">案例展示</a></li><li><a href="javascript:void(0);">资质证书</a></li><li><a href="javascript:void(0);">团队成员</a></li><div class="clear"></div></div>  <div class="content"><div class="clear"></div>
<?php /*?>业主评价<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php 
if(!empty($evaluate)){
foreach($evaluate as $rs){
?><tr><td width="417"><span><?php echo $this->User_Model->links($rs->uid)?>：<?php echo $rs->note?></span></td><td width="100"><?php echo dateYMD($rs->addtime)?> </td></tr><?php }}else{?><tr><td colspan="3" align="left">暂无评价信息</td></tr><?php }?></table></div>
<?php /*?>服务项目<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><tr><td width="566"><?php if(!empty($user->team_fwdq)){echo $user->team_fwdq;}else{echo '暂未添加服务项目!';}?></td></tr></table></div>
<?php /*?>服务地区<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><tr><td width="566"><?php if(!empty($user->team_fwxm)){echo $user->team_fwxm;}else{echo '暂未添加服务地区!';}?></td></tr></table></div>
<?php /*?>参考报价<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><tr><td width="566"><?php if(!empty($user->team_ckbj)){echo $user->team_ckbj;}else{echo '暂未添加参考报价!';}?></td></tr></table></div>
<?php /*?>案例展示<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php if(!empty($cases)){
foreach($cases as $rs){?><tr><td width="417"><a target="_blank" title="<?php echo $rs->title?>" href="<?php echo site_url("case/view/".$rs->id)?>"><?php echo $rs->title?></a></td><td width="149"><?php echo dateYMD($rs->addtime)?></td></tr><?php }}else{?><tr><td colspan="3" align="center">暂未添加案例</td></tr><?php }?></table></div>
<?php /*?>资质证书<?php */?><div class="tab_item"><div class="zhengshu"><?php if(!empty($zhengshu)){
foreach($zhengshu as $rs){?><div style="list-style:none; padding:0; margin:0; list-style-type:none; display:inline-table;"><a href="<?php echo $rs->pic?>" rel="lightbox[plants]" title="<?php echo $rs->content?>" class="tip"><li><img src="<?php echo $rs->pic?>" width="100" /></li></a></div><?php }}else{?>暂未添加资质证书<?php }?><div class="clear"></div></div></div>
<?php /*?>团队成员<?php */?><div class="tab_item"><div class="friends"><?php 
if(!empty($recommend)){
foreach($recommend as $rs){
?><li><div class="dd"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>" style=" float:left;width:50px;height:50px;overflow:hidden;" title="<?php echo $rs->note?>" class="tip"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><?php echo $rs->name?></a><br /><?php echo dateYMD($rs->addtime)?></div></li><?php }}else{?><div style="padding:4px;">暂无团队成员!</div><?php }?></div></div>
<div class="clear"></div></div></div><div class="bottom"></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>