<?php $this->load->view('public/header'); ?><style>.butsearch{position:absolute;right:5px; padding-top:2px;}.butsearch img{-moz-box-shadow:2px 2px 6px #ccc;-webkit-box-shadow:2px 2px 6px #ccc;box-shadow:2px 2px 6px #ccc;}</style><?php /*?>收展技术栏并记录状态<?php */?><script language="javascript" type="text/javascript"> 
$(function(){
	$("#skills_box #btu_skill_change").click(function(){
		updown();
		var isopen=$("#skills_box").attr("isopen");
		if(isopen=="1"){isopen="1";}else{isopen="0";}
		$.ajax({type:'GET',url:'<?php echo site_url("search/open")?>?isopen='+isopen});
	   });
	<?php /*?>设计师样式 "font-weight":"bold"<?php */?>
	$("#search_industry").find("a#612").css({"color":"#F60"});
	<?php /*?>页面加载完成,技能框自适应高度<?php */?>
	fitheight();
});<?php /*?>返回工种对应的项目<?php */?>
function skills(ty){
	var classid = $(".click_box #classid").val();
	var industryid = "";
	$("#search_industry a").each(function(){
   <?php /*?>获取被选中的工种<?php */?>
	   if($(this).attr("class")=="on"){industryid=industryid+$(this).attr("id")+"_";}
	   });
   <?php /*?>加载技能<?php */?>
	var sUrl="/search/app_skills/"+classid+"/"+industryid+"/";
	if(ty==1){
	  <?php /*?>热门技能<?php */?>
	  $("#hot_search_skills").load(sUrl+"/1",function(){});
	}else{
	  <?php /*?>所以相关技能<?php */?>
	  $("#search_skills").load(sUrl+"/0",function(){fitheight();});	 
	}
}<?php /*?>返回搜索url参数发<?php */?>
function searchkeys(){return searchUrl();}</script></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><div class="search_left"><div class="box boxbg"><li style="border:0;background:none;" sbut="first"><dd id="search_areas">按地区</dd><dt style="height:auto;">   <?php /*?>城市选择<?php */?><div class="city_select"><div class="citys" style="margin-bottom:0;"><div id="areas" class="click_box" isfor="1"><a href="javascript:void(0);" id="no" <?php if(is_numeric($area_id)==false){?>class="on"<?php }?>>不限</a><?php
if(!empty($areas)){ foreach($areas as $rs){?><a href="javascript:void(0);" id="<?php echo $rs->a_id?>" <?php if($area_id==$rs->a_id){?>class="on"<?php }?>><?php echo $rs->a_name?></a><?php }}?></div><div class="clear"></div></div></div></dt></li>  
     <li sbut="yes"><dd>按类型</dd><dt class="click_box" isfor="1" id="search_team_or_men"><?php slistitems($team_mens,$team_mens_id,"不限",0)?></dt></li>
 <li sbut="yes"><dd>按工种</dd><dt class="click_box" isfor="0" id="search_industry"><?php slistitems($industrys,$industry_id,"不限",0)?></dt></li>
 
 <?php
//当搜索设计师时,隐藏
if($industry_id!="612"){?>
<li sbut="yes"><dd>按项目</dd><dt class="click_box"><div style="padding:0; padding-bottom:4px;padding-right:3px;"><select name="classid" id="classid" style="padding:0;margin:0;margin-right:3px; margin-top:3px;"><option value="no">不限</option><?php
foreach($industry_class as $icrs){
  if($icrs->id==$class_id){$style=" class='inputSelet' selected='selected'";}else{$style="";}
  echo "<option ".$style." value='".$icrs->id."' >".$icrs->title."</option>";
}
?></select><span id="hot_search_skills" isfor="0"><?php slistitems($skills_hot,$skills_hot_id,"不限",0)?></span></div><div class="clear"></div><?php
//处理展开框状态
if($isopen==1){
  $isopen=1;$arrow_ico="btu_skill_up";$open_h="auto";
}else{
  $isopen=0;$arrow_ico="btu_skill_down";$open_h="84px";
}
?><style>.search_left .box li .click_box #skills_box{height:<?php echo $open_h?>;}</style><div id="skills_box" isopen="<?php echo $isopen?>" <?php if($class_id==""){echo " style='height:0;'";}?> ><div class="updown"><button id="btu_skill_change" class="<?php echo $arrow_ico?>" >&nbsp;</button></div><div id="search_skills" isfor="0"><?php slistitems($skills,$skills_id,"不限",0)?><div class="clear"><!--[if IE 6]><![endif]--></div></div></div></dt></li><?php }?>
           <li sbut="yes"><dd>按等级</dd><dt class="click_box" isfor="1" id="search_level"><?php slistitems($levels,$level_id,"不限",0)?></dt></li>
<li sbut="yes"><dd>按年限</dd><dt class="click_box" isfor="1" id="search_age"><?php slistitems($ages,$age_id,"不限",0)?></dt></li>
<li sbut="yes"><dd>按认证</dd><dt class="click_box" isfor="0" id="search_approve"><?php slistitems($approves,$approve_id,"不限",0)?></dt></li><!--清除浮动--><div class="clear"></div></div>
<?php /*?>展开收缩按钮<?php */?><div id="but_show">&nbsp;</div>
   <div class="box">
<?php
if(!empty($list)){
	foreach ($list as $rs){?>
<?php if($rs->classid==2&&$rs->uid==1){ /*企业用户*/ ?>
<div class="worker"><table width="100%" border="0" cellpadding="0" cellspacing="2"><tr><td rowspan="3" align="center" valign="top"><div class="pic"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceB($rs->photoID)?>" /></a></div>
</td><td width="600" class="seach_item_top"><div class="left" style="line-height:200%;"><span class="gtitle"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><?php echo $rs->truename?></a><span class="team_name">&nbsp;</span></span></div>
<div class="center"><span class="gtitle"><?php //=g_citys($row["city"])?> <?php //=g_areas($row["area"])?>&nbsp;</span></div><div class="right">经营：<?php echo $this->User_Model->entry($rs->entry_age)?></div>
</td></tr><tr><td height="80" valign="top" class="seach_item_body">

<span class="gtitle">服务简要：</span>
<br />
<?php
$note_adv = txt2arr($rs->addr_adv);
if(!empty($note_adv)){
	foreach($note_adv as $nitem)
	{
		$nitem = cutstr($nitem,46);
?><li class="lbg" style="width:530px;"><?php echo keycolor($nitem,$keyword)?></li><?php }}?>
</td></tr>

<?php /*?>
<tr><td><div class="left"><div class="rz_ico"><?php //if($row["classid"]==2){?><?php if(1==2){?><span class="chuangjianzhe_info">
创建者： <?php echo $this->Industry_User->links($gsrs->uid)?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo g_user($gsrs->uid,"qq")?>&site=qq&menu=yes"><img title="QQ交谈!" src="views/images/search/search_qq.gif" width="20" height="20" align="absmiddle" /></a></span><?php }else{?>
<?php echo $this->User_Model->approves($rs->id,'<a class="yz_{tip}" title="{title}">&nbsp;</a>');?><?php }?><div class="clear"></div></div></div>
<div class="center">&nbsp;</div><div class="right" style="width:160px;"><span class="diy_buttom seach_item_diy_buttom" userid="<?php echo $rs->id?>"><span class="favorites"><a href="javascript:void(0);" class="buttom tip" title="放入收藏夹">收藏</a></span><span class="order"><a href="javascript:void(0);" class="buttom tip" title="下单给他">雇佣</a></span></span></div></td></tr>
<?php */?>

</table>
<div style="position:relative;">
<?php /*?>企业印章<?php */?>
<div style="width:50px; height:50px; position:absolute; bottom:0; right:12px;">
<img class="tip" title="淘工人认证企业!" src="<?php echo $img_url?>ico/tao_ok.gif" height="50" width="50" /></div></div>
</div>
<?php }else{?>
<div class="worker"><table width="100%" border="0" cellpadding="0" cellspacing="2"><tr><td rowspan="3" align="center" valign="top"><div class="pic"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceB($rs->photoID)?>" /></a></div><div style="text-align:center;"><?php #判断是否已经登录 ?><a href="javascipt:void(0);" class="look_mobile">查看联系方式</a>&nbsp;&nbsp;&nbsp;</div>
</td><td width="600" class="seach_item_top"><div class="left" style="line-height:200%;"><span class="gtitle"><a target="_blank" href="<?php echo site_url("user/".$rs->id)?>"><?php echo $this->User_Model->name($rs->id)?></a><span class="team_name">&nbsp;</span></span></div>
<div class="center"><span class="gtitle"><?php //=g_citys($row["city"])?> <?php //=g_areas($row["area"])?>&nbsp;</span></div><div class="right">从业：<?php echo $this->User_Model->entry($rs->entry_age)?></div>
</td></tr><tr><td height="80" valign="top" class="seach_item_body">
   <span class="gtitle">擅长工种</span>：<?php
$goodat_industrys = $this->Industry_Model->goodat_industrys($rs->id);
if(!empty($goodat_industrys)){$i=0;
	foreach($goodat_industrys as $girs){
		$i++;	
?><span><?php if($i>1){echo "、";}?><?php echo $girs->title;?></span><?php }}?><br /><span class="gtitle">擅长项目</span>：<?php
$goodat_skills = $this->Industry_Model->goodat_skills($rs->id);
if(!empty($goodat_skills)){$i=0;
	foreach($goodat_skills as $gsrs){
		$i++;	
?><span><?php if($i>1){echo "、";}?><?php echo keycolor($gsrs->title,$keyword) ?></span><?php }}?>
<br />
<?php
$addr_adv = $rs->addr_adv;
if($addr_adv!=""){?><span class="gtitle">位置优势</span>：
本人承诺在 <strong style="background-color:#F60"><?php echo keycolor($addr_adv,$keyword)?></strong> 范围内免收上门费用<?php }?>
</td></tr><tr><td><div class="left"><div class="rz_ico"><?php //if($row["classid"]==2){?><?php if(1==2){?><?php /*?>团队的<?php */?><span class="chuangjianzhe_info">
创建者： <?php echo $this->Industry_User->links($gsrs->uid)?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo g_user($gsrs->uid,"qq")?>&site=qq&menu=yes"><img title="QQ交谈!" src="views/images/search/search_qq.gif" width="20" height="20" align="absmiddle" /></a></span><?php }else{?><?php /*?>工人的<?php */?>
<?php echo $this->User_Model->approves($rs->id,'<a class="yz_{tip}" title="{title}">&nbsp;</a>');?><?php }?><div class="clear"></div></div></div>
<div class="center">&nbsp;</div><div class="right" style="width:160px;"><span class="diy_buttom seach_item_diy_buttom" userid="<?php echo $rs->id?>"><span class="favorites"><a href="javascript:void(0);" class="buttom tip" title="放入收藏夹">收藏</a></span><span class="order"><a href="javascript:void(0);" class="buttom tip" title="下单给他">雇佣</a></span></span></div></td></tr></table></div>
<?php }?>

<?php }}else{?><div class="worker" style="text-align:center; line-height:50px;">暂未找到相关的工人！</div><?php }?>

<div class="clear"></div><div style="padding-top:6px;"><?php $this->Paging->links(); ?></div></div></div>
  
<div class="search_right"><div class="index_right"><div class="right_box"><div class="recommendbox" style="padding:0;"><a href="http://www.xmdec.com/" target="_blank"><img alt="广州市旭美装饰工程有限公司" title="广州市旭美装饰工程有限公司" src="<?php echo $img_url;?>ads/xumei.jpg" width="206" /></a></div>

<div class="yx_recomm">
<div class="tab_title">英雄榜</div>
<div class="clear"></div>

<?php foreach($user_yxb as $rs){?>
<div class="item">
<div class="photo"><a target="_blank" href="<?php echo site_url("/user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceB($rs->photoID)?>" /></a></div>
<div class="name"><?php echo $rs->name?>&nbsp; &nbsp;<span class="entry_age"><?php echo $this->User_Model->entry($rs->entry_age)?></span></div>
<div class="skills">
<?php
/*用户擅长工种*/
$goodat_industrys = $this->Industry_Model->goodat_industrys($rs->id);
if(!empty($goodat_industrys)){ $inum=0;
   foreach($goodat_industrys as $gi_rs){ $inum++; echo "<span>".$gi_rs->title."</span>"; if($inum>1){echo "、";} }
}
?>
</div>
<div class="clear"></div></div>
<?php }?>

</div></div></div></div>
<!--清除浮动--><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>