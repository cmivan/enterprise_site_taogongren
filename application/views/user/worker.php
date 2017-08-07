<?php $this->load->view('public/header');?>
<?php /*?>排期日历<?php */?>
<?php /*?><script type="text/javascript" src="<?php echo $js_url?>mod_poshytip.js"></script><?php */?>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/prototype.js"></script>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="<?php echo $js_url?>lightbox/lightbox.js"></script>
<script type="text/javascript" src="<?php echo $js_url?>fullcalendar/fullcalendar.min.js"></script>
<?php /*?><script language="javascript" type="text/javascript" src="<?php echo $js_url?>jquery-ui-1.8.6.custom.min.js"></script><?php */?>
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
});</script>
<script type="text/javascript"> 
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
<?php
//评级
if(!empty($rating_class)){
foreach($rating_class as $rs){
	echo '$(".pingji dt#dpStar'.$rs->id.'").removeClass().addClass("selectS'.$this->Evaluate_Model->rating_sroc($user->id,$rs->id).'");'.chr(10);
}}
?>
});</script>
 
</head><body><?php $this->load->view('public/top');?><div class="main_width"><div class="body_main"><div class="body_left"><div class="content_box"><div class="content"><div class="info_top uid" uid="<?php echo $user->id?>"><div class="left"><a href="<?php echo site_url("user/".$user->id)?>"><img src="<?php echo $this->User_Model->faceB($user->photoID)?>" width="95" height="122" /></a></div>
<div class="right"><div class="name"><?php echo $user->name?></div><div><?php echo $user->c_name?>&nbsp;<?php echo $user->a_name?></div><div><span>等级：<button id="ico_levels" class="level_1">&nbsp;</button></span></div><div><span class="haoping">好评率：<?php echo $haoping_sroc?></span></div><div id="team_buttom"><div class="team_tilte"><img src="<?php echo $img_url?>ico/cilun.gif" align="absmiddle" />&nbsp;<?php echo $nicetitle?>的团队 <button id="btu_team_arrow" class="btu_team_arrow_down">&nbsp;</button></div><div class="team_box"><?php if($team_but==0){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;暂未创建<br /><?php }elseif($team_but==1){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a target="_blank" href="<?php echo site_url("/user/".$Tid)?>" id="<?php echo $Tid?>"><?php echo $this->User_Model->name($Tid)?></a><br /><?php }elseif($team_but==2){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a href="javascript:void(0);" id="<?php echo $user->id?>" class="cj_team">创建团队</a><br /><?php }?></div></div>
                   </div><div class="clear"></div></div>
<div class="info_edit"><div class="left"><?php echo $approves;?></div><div class="right" userid="<?php echo $user->id?>"><a href="javascript:void(0);" class="tip yz_buy" title="下单给他">&nbsp;</a><a href="javascript:void(0);" class="tip yz_favorites" title="放入收藏夹">&nbsp;</a><a href="javascript:void(0);" class="tip yz_friend" title="加他为好友">&nbsp;</a><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $user->qq?>&site=qq&menu=yes" class="tip yz_qq" title="和他QQ交谈">&nbsp;</a><a href="javascript:void(0);" class="tip send_msg" title="发送站内消息">&nbsp;</a></div><div class="clear"></div></div><div class="clear"></div></div></div>
   <div class="content_box"><div class="title"><h1>个人介绍</h1><div class="clear"></div></div><div class="content" style="text-indent:20px;"><?php echo noHtml($user->note)?></div></div>
   <div class="content_box"><div class="title" style="height:48px;"><li>累积信用：<?php echo ceil($credits)?> <img src="<?php echo $img_url?>ico/gold.gif" width="13" height="15" align="absmiddle" /></li><li>总计收入：<?php echo ceil($balances)?> </li><li>揽活次数：<?php echo $jobtimes?> 次</li><li>从业时间：<?php echo $this->User_Model->entry($user->entry_age)?></li><div class="clear"></div></div>
 <div class="content" style="position:relative;"><div class="pingji"><?php
if(!empty($rating_class)){
   foreach($rating_class as $rs){
?><li><dd><?php echo $rs->title?></dd><dt id="dpStar<?php echo $rs->id?>"><?php for($i=1;$i<=5;$i++){?><a id="<?php echo $i?>">&nbsp;</a><?php }?><a class="scor"></a></dt></li><?php }}?>
 </div><div class="clear"></div></div></div>
 <div class="content_box"><div class="title"><h1>好友</h1><div class="clear"></div></div><div class="content"><div class="friends">
<?php if(!empty($friend1)){?><?php foreach($friend1 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->fuid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->fuid)?>" title="<?php echo $rs->name?>"><?php echo cutstr($rs->name,5)?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>
<?php if(!empty($friend2)){?><?php foreach($friend2 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->uid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->uid)?>" title="<?php echo $rs->name?>"><?php echo cutstr($rs->name,5)?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>

<div class="clear"></div><?php /*?><div style="position:relative;"><div class="more"><a href="javascript:void(0);">更多<img src="<?php echo $img_url?>ico/down.gif" width="15" height="16" align="absmiddle" /></a></div></div><?php */?>
</div><div class="clear"></div></div></div></div>
 <div class="body_right"><div class="content_box"><div class="title"><h1>个人信息</h1><span>已有<em><?php echo $user->visited?></em>人浏览</span><div class="clear"></div></div><div class="content"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="4"><tr>
  <td width="46" align="right" class="maintitle">姓名：</td>
  <td><?php echo $user->name?></td>
  <td width="60" align="right" class="maintitle">年龄：</td>
  <td width="135"><?php echo dataAge($user->birthday)?>岁</td>
  <td width="60" align="right" class="maintitle">性别：</td>
  <td width="180"><?php if($user->sex==0){echo "男";}else{echo "女";}?></td>
  </tr><tr>
  <td align="right" class="maintitle">编号：</td>
  <td width="101">TG-<?php echo $user->id?></td>
  <td align="right" class="maintitle">手机：</td>
  <td class="mobile">
  <?php /*?><div class="mobile_box" userid="<?php echo $user->id?>" gid="1"><?php echo $mobile_mark?></div><?php */?>
  <?php echo $user->mobile?>
  </td>
  <td align="right" class="maintitle">邮箱：</td>
  <td><?php echo $user->email?></td></tr><tr><td align="right" class="maintitle">现居：</td><td colspan="5"><?php echo $user->p_name?> <?php echo $user->c_name?> <?php echo $user->a_name?> <?php echo $user->address?></td></tr>
  <tr>
    <td align="right" class="maintitle tip" title="温馨提示"><span class="red">提示：</span></td>
    <td colspan="5"><span class="red">如果该信息能帮助到您，请转告给您的朋友，让更多朋友可以快速找到帮手！</span></td>
  </tr>
  <?php if($user->addr_adv!=""){?>     <tr><td align="right" class="maintitle tip" title="位置优势">优势：</td><td colspan="5">
本人承诺在 <strong style="color:#03F; text-decoration:underline"><?php echo $user->addr_adv?></strong> 范围内免收上门费用</span></td></tr>
  <?php }?></table></td></tr></table></div></div>

<div class="content_box" box="content_box"><div class="title"><h1>擅长工种</h1>
<?php echo $goodat_industrys;?>
<div class="clear"></div></div>
 <div class="content" id="wroks_skill">  
<?php if($skills_count>0){?>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_line">
<?php
//读取分类
if(!empty($goodat_classes)){
  foreach($goodat_classes as $gc_rs){
?><tr class="edit_item_tr">
<td width="6%" height="28" align="center" class="maintitle"><?php echo $gc_rs->title?></td>
<td class="works_skills_box">
<?php
//读取用户工种
$gc_industrys=$this->Industry_Model->goodat_class_industrys($gc_rs->id,$user->id);
if(!empty($gc_industrys)){
  $inum=0;
  foreach($gc_industrys as $gci_rs){
	$inum++;
	if($inum>1){echo "<div class='hr'>&nbsp;</div>";}
//读取项目
$gci_skills=$this->Industry_Model->goodat_class_industry_skills($gc_rs->id,$gci_rs->id,$user->id);

if(!empty($gci_skills)){
   foreach($gci_skills as $gcis_rs){
	 $pro_tip="";
	 $pro_css="";
	 if(is_numeric($gcis_rs->price)&&$gcis_rs->price!=0&&$gcis_rs->note!=""){
		 $pro_tip="，报价:".$gcis_rs->price."(元)";
		 $pro_css=" style='color:#F00;text-decoration:underline'  class='tip'";
		 }
?><div id="<?php echo $gcis_rs->id?>"><a href="javascript:void(0);" title="<?php echo $gcis_rs->title.$pro_tip?>" <?php echo $pro_css?>><?php echo $gcis_rs->title?></a></div>
<?php }}}}?></td></tr><?php	}?></table><?php }else{?><div class="industry_box" style="text-align:center"><br>暂未添加技能!<br /><br /></div><?php
	}}
?>
 </div></div>
   
   <div class="content_tab"><div class="top"></div>
   <div class="box">
      <div class="tab_nav">
      <li><a href="javascript:void(0);">业主评价</a></li>
      <li><a href="javascript:void(0);">参考报价</a></li>
      <li><a href="javascript:void(0);">案例展示</a></li>
      <li><a href="javascript:void(0);">最近排期</a></li>
      <li><a href="javascript:void(0);">资质证书</a></li>
      <li><a href="javascript:void(0);"><?php echo $nicetitle?>的推荐</a></li>
      <li><a href="javascript:void(0);"><?php echo $nicetitle?>的投标</a></li>
      <div class="clear"></div>
      </div>
      <div class="content"><div class="clear"></div>
 
<?php /*?>业主评价<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php 
if(!empty($evaluate)){
foreach($evaluate as $rs){
?><tr><td width="417"><span><?php echo $this->User_Model->links($rs->uid)?>：<?php echo $rs->note?></span></td><td width="100"><?php echo dateYMD($rs->addtime)?> </td></tr><?php }}else{?><tr><td colspan="3">暂无评价信息</td></tr><?php }?></table></div>
<?php /*?>参考报价<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php 
if(!empty($skills)){
foreach($skills as $rs){
?><tr><td width="417">&nbsp;&nbsp;<span title="<?php echo $rs->title?>" href="javascript:void(0);"><?php echo $rs->title?></span></td><td width="100"><span class="chenghong"><?php echo $rs->price?></span> 元</td></tr><?php }}else{?><tr><td colspan="3">暂未添加项目报价</td></tr><?php }?></table></div>
<?php /*?>案例展示<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php 
if(!empty($cases)){
foreach($cases as $rs){
?><tr><td width="417"><a target="_blank" title="<?php echo $rs->title?>" href="<?php echo site_url("/user/cases/".$rs->id)?>"><?php echo $rs->title?></a></td><td width="100"><?php echo dateYMD($rs->addtime)?></td></tr><?php }}else{?><tr><td colspan="3">暂未添加案例</td></tr><?php }?></table></div>
<?php /*?>最近排期<?php */?><div class="tab_item" id="calendar"></div>
<?php /*?>资质证书<?php */?>
<div class="tab_item"><div class="zhengshu">
<?php 
if(!empty($zhengshu)){
foreach($zhengshu as $rs){
?><div style="list-style:none; padding:0; margin:0; list-style-type:none; display:inline-table;"><a href="<?php echo img_cases($rs->pic)?>" rel="lightbox[plants]" title="<?php echo $rs->content?>" class="tip"><li><img src="<?php echo img_cases($rs->pic)?>" width="100" /></li></a></div><?php }}else{?>
暂未添加相关证书<?php }?><div class="clear"></div></div></div>
<?php /*?>我的推荐<?php */?><div class="tab_item"><div class="friends"><?php 
if(!empty($recommend)){
foreach($recommend as $rs){
?><li><div class="dd"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>" style=" float:left;width:50px;height:50px;overflow:hidden;" title="<?php echo $rs->note?>" class="tip"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><?php echo $rs->name?></a><br /><?php echo dateYMD($rs->addtime)?></div></li><?php }}else{?><div style="padding:4px;">暂未添加推荐!</div><?php }?></div></div>
<?php /*?>投标<?php */?><div class="tab_item"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="ltable"><?php 
if(!empty($retrieval)){
foreach($retrieval as $rs){
?><tr><td width="417" title="<?php echo $rs->title?>"><a href="<?php echo site_url("retrieval/view/".$rs->id)?>" target="_blank"><?php echo $rs->title?></a></td><td width="100"><?php echo dateYMD($rs->addtime)?></td></tr><?php }}else{?><tr><td colspan="3">暂未参加投标</td></tr><?php }?></table></div>
<div class="clear"></div></div></div><div class="bottom"></div></div></div><div class="clear"></div></div>
</div>
<?php $this->load->view('public/footer');?>