<?php $this->load->view('public/header');?>
<script type="text/javascript"> 
$(function(){
<?php //评级
if(!empty($rating_class)){
foreach($rating_class as $rs){
	echo '$(".pingji dt#dpStar'.$rs->id.'").removeClass().addClass("selectS'.$this->Common_Model->rating_sroc($user->id,$rs->id).'");'.chr(10);
}}
?>
});</script>
</head><body><?php $this->load->view('public/top');?>
<div class="main_width"><div class="body_main"><div class="body_left">
   <div class="content_box">
      <div class="content">
            <div class="info_top uid" uid="<?php echo $user->id?>"><div class="left"><a href="<?php echo site_url("user/".$user->id)?>"><img src="<?php echo $this->User_Model->faceB($user->photoID)?>" width="95" height="122" /></a></div>
<div class="right"><div class="name"><?php echo $user->name?></div><div><?php echo $user->c_name?>&nbsp;<?php echo $user->a_name?></div><div><span>等级：<button id="ico_levels" class="level_<?php echo $level;?>">&nbsp;</button></span></div><div><span class="haoping">好评率：<?php echo $haoping_sroc?></span></div>
 <div id="team_buttom"><div class="team_tilte"><img src="<?php echo $img_url?>ico/cilun.gif" align="absmiddle" />&nbsp;<?php echo $nicetitle?>的团队 <button id="btu_team_arrow" class="btu_team_arrow_down">&nbsp;</button></div><div class="team_box"><?php if($team_but==0){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;暂未创建<br /><?php }elseif($team_but==1){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a target="_blank" href="<?php echo site_url("/user/".$Tid)?>" id="<?php echo $Tid?>"><?php echo $this->User_Model->name($Tid)?></a><br /><?php }elseif($team_but==2){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a href="javascript:void(0);" id="<?php echo $user->id?>" class="cj_team">创建团队</a><br /><?php }?></div></div>
                   </div><div class="clear"></div></div>
<div class="info_edit"><div class="left"><?php echo $approves;?></div><div class="right" userid="<?php echo $user->id?>"><a href="javascript:void(0);" class="tip yz_buy" title="下单给他">&nbsp;</a><a href="javascript:void(0);" class="tip yz_favorites" title="放入收藏夹">&nbsp;</a><a href="javascript:void(0);" class="tip yz_friend" title="加他为好友">&nbsp;</a><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $user->qq?>&site=qq&menu=yes" class="tip yz_qq" title="和他QQ交谈">&nbsp;</a><a href="javascript:void(0);" class="tip send_msg" title="发送站内消息">&nbsp;</a></div><div class="clear"></div></div><div class="clear"></div></div></div>
   <div class="content_box"><div class="title"><h1>个人介绍</h1><div class="clear"></div></div><div class="content" style="text-indent:20px;"><?php echo noHtml($user->note)?></div></div>
   <div class="content_box"><div class="title" style="height:48px;"><li>累积信用金：<?php echo $credits?> <img src="<?php echo $img_url?>ico/gold.gif" width="13" height="15" align="absmiddle" /></li><li>总计收入：<?php echo ceil($balances)?> </li><li>揽活次数：<?php echo $jobtimes?> 次</li><li>从业时间：<?php echo $this->User_Model->entry($user->entry_age)?></li><div class="clear"></div></div>
 <div class="content" style="position:relative;"><div class="pingji"><?php
if(!empty($rating_class)){
   foreach($rating_class as $rs){
?><li><dd><?php echo $rs->title?></dd><dt id="dpStar<?php echo $rs->id?>"><?php for($i=1;$i<=5;$i++){?><a id="<?php echo $i?>">&nbsp;</a><?php }?><a class="scor"></a></dt></li><?php }}?>
 </div><div class="clear"></div></div></div>
 <div class="content_box"><div class="title"><h1>好友</h1><div class="clear"></div></div><div class="content"><div class="friends">
<?php if(!empty($friend1)){?><?php foreach($friend1 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->fuid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->fuid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>
<?php if(!empty($friend2)){?><?php foreach($friend2 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->uid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->uid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>

<div class="clear"></div><?php /*?><div style="position:relative;"><div class="more"><a href="javascript:void(0);">更多<img src="<?php echo $img_url?>ico/down.gif" width="15" height="16" align="absmiddle" /></a></div></div><?php */?>
</div><div class="clear"></div></div></div></div>
 <div class="body_right"><div class="content_box"><div class="title"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><h1>求职信息</h1></td><td width="80" align="center"><a href="<?php echo site_url("user/".$view->uid)?>">查看主页</a></td></tr></table><div class="clear"></div></div><div class="content tipbox" style="padding-left:8px; padding-right:8px; width:auto; background-image:none;"><table width="100%" border="0" cellpadding="0" cellspacing="8" class="big_text"><tr><td height="40" colspan="2" align="left" style="font-size:18px; font-weight:bold;color:#333;border-bottom:#CCC 1px dotted"><?php echo $view->title?></td></tr><tr><td width="50%" align="left">发布时间：<?php echo date("m月d日 H:i",strtotime($view->addtime))?>&nbsp;</td><td width="50%" align="left">查看次数：<?php echo $view->visited?></td></tr><tr><td valign="top">地址：<?php echo $view->c_addr?></td><td valign="top">工资：<?php echo $view->cost?></td></tr><tr><td valign="top">待遇：<?php echo $view->fuli?></td><td valign="top">发布人：<?php echo $this->User_Model->links($view->uid)?></td></tr><tr><td colspan="2" valign="top">擅长工种：<?php echo $this->Retrieval_Model->show_industrys($view->industryid)?></td></tr><tr><td height="632" colspan="2" valign="top" style="border-top:#CCC 1px dotted; padding-top:10px;"><?php echo $view->content?></td></tr><tr><td colspan="2" align="right" valign="top">&nbsp;</td></tr></table></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>