<?php $this->load->view('public/header'); ?>
<?php /*?>绑定倒计时<?php */?>
<script type="text/javascript" src="<?php echo $js_url;?>retrieval/retrieval_timeout.js"></script>
<script type="text/javascript"> 
$(function(){ $("#END_TIME").CRcountDown({startDate:"<?php echo dateYMD($view->endtime,1)?>",callBack:function(){}}).css("color",""); });</script>
<?php /*?>LightBox v2.0<?php */?>
<script type="text/javascript" src="<?php echo $js_url;?>lightbox/prototype.js"></script>
<script type="text/javascript" src="<?php echo $js_url;?>lightbox/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="<?php echo $js_url;?>lightbox/lightbox.js"></script>
<script type="text/javascript"> 
$(function(){
	<?php /*?>初始化tab隐藏<?php */?>
	$(".content_box").find(".title").find("a").attr("class","");
	$(".content_box").find(".content").find("div.tab_item").css({display:"none"});
	<?php /*?>初始化tab选中第一项<?php */?>
	$("#retrieval_top").find(".title").find("a").eq(0).attr("class","on");
	$("#retrieval_top").find(".content").find("div.tab_item").eq(0).css({display:"block"});
	$("#retrieval_left_1").find(".title").find("a").eq(0).attr("class","on");
	$("#retrieval_left_1").find(".content").find("div.tab_item").eq(0).css({display:"block"});
	$("#retrieval_left_2").find(".title").find("a").eq(0).attr("class","on");
	$("#retrieval_left_2").find(".content").find("div.tab_item").eq(0).css({display:"block"});	
	<?php /*?>顶部tab<?php */?>
	$("#retrieval_top").find(".title").find("a").click(
		function(){
			var TIndex=$("#retrieval_top").find(".title").find("a").index(this);
			$("#retrieval_top").find(".title").find("a").attr("class","");
			$(this).attr("class","on");
			$("#retrieval_top").find(".content").find("div.tab_item").css({display:"none"});
			$("#retrieval_top").find(".content").find("div.tab_item").eq(TIndex).css({display:"block"});
	 });
    <?php /*?>左边tab1<?php */?>
	$("#retrieval_left_1").find(".title").find("a").click(
		function(){
			var TIndex=$("#retrieval_left_1").find(".title").find("a").index(this);
			$("#retrieval_left_1").find(".title").find("a").attr("class","");
			$(this).attr("class","on");
			$("#retrieval_left_1").find(".content").find("div.tab_item").css({display:"none"});
			$("#retrieval_left_1").find(".content").find("div.tab_item").eq(TIndex).css({display:"block"});
	 });
    <?php /*?>左边tab2<?php */?>
	$("#retrieval_left_2").find(".title").find("a").click(
		function(){
			var TIndex=$("#retrieval_left_2").find(".title").find("a").index(this);
			$("#retrieval_left_2").find(".title").find("a").attr("class","");
			$(this).attr("class","on");
			$("#retrieval_left_2").find(".content").find("div.tab_item").css({display:"none"});
			$("#retrieval_left_2").find(".content").find("div.tab_item").eq(TIndex).css({display:"block"});
	 });
   <?php /*?>鼠标移动到工人投标信息上<?php */?>
   $(".worker_item").find(".content_box").hover(
	   function(){
		   $(this).parent().parent().find(".content_box").css({"border":"#FAEBD7 2px solid"});
		   $(this).parent().parent().find(".content_box").find(".yz_buy").css({"display":"none"});
		   $(this).css({"border":"#F90 2px solid"});
		   $(this).find(".yz_buy").css({"display":"block"});
		   },function(){});<?php
//评级
if(!empty($rating_class)){
foreach($rating_class as $rs){
	echo '$(".pingji dt#dpStar'.$rs->id.'").removeClass().addClass("selectS'.$this->Common_Model->rating_sroc($user->id,$rs->id).'");'.chr(10);
}}
?>
});</script></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><div class="body_left"><div class="content_box"><div class="content"><div class="info_top uid" uid="<?php echo $user->id?>" rid="<?php echo $view->id?>"><div class="left"><a href="javascript:void(0);"><img src="<?php echo $this->User_Model->faceB($user->photoID)?>" width="95" height="122" /></a></div><div class="right"><div class="name"><?php echo $user->name?></div><div>所在地： <?php echo $user->c_name?>&nbsp;<?php echo $user->a_name?></div><div><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="40">手机：</td><td class="mobile"><div class="mobile_box" userid="<?php echo $view->uid?>" gid="1"><?php echo $mobile_mark?></div></td></tr></table></div><div><span class="haoping">好评率：<?php echo $haoping_sroc?></span></div>
<div class="info_edit" style="width:auto;"><div class="right" userid="<?php echo $user->id?>"><a href="javascript:void(0);" class="tip yz_favorites" title="放入收藏夹">&nbsp;</a><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $user->qq?>&site=qq&menu=yes" class="tip yz_qq" title="和他QQ交谈">&nbsp;</a><a href="javascript:void(0);" class="tip send_msg" title="发送站内消息">&nbsp;</a></div></div></div><div class="clear"></div></div>
<div class="clear"></div>
<div class="content" style="position:relative;"><div class="pingji">
<?php
if(!empty($rating_class)){
   foreach($rating_class as $rs){
?>
<li><dd><?php echo cutstr($rs->title,18)?></dd><dt id="dpStar<?php echo $rs->id?>"><?php for($i=1;$i<=5;$i++){?><a id="<?php echo $i?>">&nbsp;</a><?php }?><a class="scor"></a></dt></li><?php }}?>
</div><div class="clear"></div>
</div>
<div class="clear"></div></div></div>
<div class="content_box" id="retrieval_left_1"><div class="title"><div class="nav"><a href="javascript:void(0);">最新投标</a><a href="javascript:void(0);">高价投标</a></div><div class="clear"></div></div>

<div class="content"><div class="tab_item"><table width="100%" border="0" cellpadding="2" cellspacing="0"><?php if(!empty($view_new)){?><?php foreach($view_new as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo cutstr($rs->title,18)?></a></td><td width="50" align="right"><?php echo format_time($rs->addtime)?>前</td></tr><?php }}else{?><tr><td colspan="2">暂无最新信息</td></tr><?php }?></table></div>
<div class="tab_item"><table width="98%" border="0" cellpadding="2" cellspacing="0"><?php if(!empty($view_max)){?><?php foreach($view_max as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo cutstr($rs->title,18)?></a></td><td width="50" align="right"><?php echo $rs->cost?>元</td></tr><?php }}else{?><tr><td colspan="2">暂无高价信息</td></tr><?php }?></table></div></div></div>
<div class="content_box" style="border:0; padding:0;"><a href="http://www.pft06.com/" target="_blank"><img src="<?php echo $img_url;?>ads/index_ad.jpg" width="300" /></a></div>
<div class="content_box" id="retrieval_left_2"><div class="title"><div class="nav"><a href="javascript:void(0);">附近投标</a><a href="javascript:void(0);">相似投标</a></div><div class="clear"></div></div>
<div class="content"><div class="tab_item"><table width="100%" border="0" cellpadding="2" cellspacing="0"><?php if(!empty($view_near)){?><?php foreach($view_near as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo cutstr($rs->title,18)?></a></td><td width="50" align="right"><?php echo $rs->a_id?></td></tr><?php }}else{?><tr><td colspan="2">没找到附近的信息</td></tr><?php }?></table></div>
<div class="tab_item"><table width="100%" border="0" cellpadding="2" cellspacing="0"><?php if(!empty($view_like)){?><?php foreach($view_like as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo cutstr($rs->title,18)?></a></td><td width="50" align="right"><?php echo $rs->id?>天前</td></tr><?php }}else{?><tr><td colspan="2">没找到相似的信息</td></tr><?php }?></table></div></div></div>

   <div class="content_box" id="retrieval_left_2"><div class="content"><div class="pic"> <?php foreach($view_img as $rs){?><li><a href="<?php echo site_url("retrieval/view/".$rs->id)?>"><img src="<?php echo img_retrieval($this,$rs->pic)?>" height="100" /></a></li><?php }?></div><div class="clear"></div></div></div></div>
<div class="body_right"><div class="content_box" id="retrieval_top"><div class="title"><div class="nav"><a href="javascript:void(0);" class="on">进行中的投标</a> <a href="javascript:void(0);">已结束的投标</a></div><div class="clear"></div></div><div class="content" style=""><div class="tab_item"><table width="100%" border="0" cellpadding="3" cellspacing="0"><?php if(!empty($view_ing)){?><?php foreach($view_ing as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo $rs->title?></a></td><td width="100" align="right">还有<?php echo format_time($rs->endtime)?></td></tr><?php }}else{?><tr><td colspan="2">没找到进行中的信息</td></tr><?php }?></table></div>
<div class="tab_item"><table width="100%" border="0" cellpadding="3" cellspacing="0"><?php if(!empty($view_end)){?><?php foreach($view_end as $rs){?><tr><td><a title="<?php echo $rs->title?>" href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo $rs->title?></a></td><td width="100" align="right"><?php echo format_time($rs->addtime)?>前</td></tr><?php }}else{?><tr><td colspan="2">没找到已结束的信息</td></tr><?php }?></table></div></div></div>
   
 
 
 <!--投标信息--><div class="content_box" box="content_box"><div class="title"><h1>当前投标</h1><div class="clear"></div></div>
<div class="view_content">   <div class="title"><div style="width:470px;">【<?php echo $where?>】<?php echo $view->title?></div>  <span><em><?php echo $view->visited?></em> 次浏览 | <em><?php echo $election_num?></em> 人投标</span></div><div class="clear"></div><div class="note">
<div class="info"><table width="556" border="0" align="center" cellpadding="0" cellspacing="5"><tr><td width="47%" height="24">投标类型：<?php echo $this->User_Model->g_team_men($view->team_or_men)?></td><td width="53%">类别：<?php echo $this->Retrieval_Model->industry_class_title($view->classid)?></td></tr>
  <tr><td height="24">预计费用：<?php echo $view->cost?> 元</td><td>工期：<?php echo dateDDD($view->job_stime)?> - <?php echo dateDDD($view->job_etime)?></td></tr><tr><td height="24" colspan="2">需求工种：<?php echo $this->Retrieval_Model->show_industrys($view->industryid)?></td></tr><tr>
  <td height="24" colspan="2" align="left">投标描述：<?php echo $view->note?></td></tr></table></div>
<?php if($pic_num>0){?>
<div class="pic_title" style="padding-top:10px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><div class="title">参考图片</div></td>
<td width="125" align="center">共 <span class="chenghong2"><?php echo $pic_num?></span> 张图片</td></tr></table></div><div class="pic">
<?php	
$sqlnum=0;
if(!empty($pics)){
foreach($pics as $rs){ $sqlnum++;
if($sqlnum>3){$listyle=' style="display:none;"';}else{$listyle='';}?><li<?php echo $listyle?>><a href="<?php echo img_retrieval($this,$rs->pic)?>" rel="lightbox[plants]" title="<?php echo $rs->note?>"><img src="<?php echo img_retrieval($this,$rs->pic)?>" width="100" alt="" /></a></li><?php }}?><div class="clear"></div></div><div class="clear bottom_b"><div class="updown"><a href="javascript:void(0);" style="background:none; border:0;"><img src="<?php echo $img_url?>search/arrow-up-black.gif" width="24" height="19" /></a></div></div><?php }?></div>

<div class="info"><table width="100%" border="0" cellpadding="0" cellspacing="5"><tr><td align="left"><table width="320" border="0" cellpadding="0" cellspacing="2"><tr><td style="font-family:Verdana, Geneva, sans-serif">&nbsp;发布时间：<?php echo dateYMD($view->addtime)?></td><td style="font-family:Verdana, Geneva, sans-serif">&nbsp;结束时间：<?php echo dateYMD($view->endtime)?></td></tr></table>
</td><td align="right" style="color:#930; font-size:16px; padding-right:15px;"><?php
if(is_num($ok_uid)==false){
if($timeover){?><span>剩余：</span><span id='END_TIME'><?php echo $view->endtime?></span><?php }else{?><span id='END_TIME'>投标已到期!</span>;<?php }}else{?><span id="END_TIME">投标已结束!</span><?php }?>
          </td></tr><tr><td colspan="2" style="color:#930; font-size:16px;">
          <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><table border="0" cellspacing="0"><tr><td align="center"><table border="0" cellpadding="0" cellspacing="1"><tr><td><img src="<?php echo $img_url?>ico/mobile_phone.gif" width="16" height="16" align="left" /></td><td><div class="mobile_box mobile" userid="<?php echo $view->uid?>" gid="2"><?php echo $mobile_mark2?></div></td></tr></table>
</td><td align="center" valign="bottom" style="padding-left:12px;"><div class="red">联系我时请说是在淘工人网看到的信息。</div></td></tr></table></td><td>
              <table width="115" border="0" align="right" cellpadding="0" cellspacing="1"><tr><td><span class="cm_btu"><?php if($timeover==true&&get_num($ok_uid)==false){?><a href="javascript:void(0);" class="buttom" id="retrieval_join" retrievalid="<?php echo $view->id?>" >参与投标</a><?php }else{?><a href="javascript:void(0);" class="buttom" id="retrieval_end" style="cursor:default;">投标已结束</a><?php }?></span></td></tr></table>
</td></tr></table></td></tr></table></div></div></div>

<!--投标信息-->
<?php
if(!empty($election_list)){
  foreach($election_list as $ers){
	$uid     = $ers->uid;
	$photoid = $this->User_Model->photoID($uid);
    $skills  = $ers->skills;
	$note    = $ers->note;
?>
<div class="worker_item"><div class="content_box" <?php if(is_numeric($ok_uid)&&$ok_uid==$uid){echo " id='retrieval_ok'";}?> ><div class="retrieval_user"><div class="left"><div class="pic"><a href="<?php echo site_url("/user/".$uid)?>?rid=<?php echo $ers->id?>" target="_blank"><img src="<?php echo $this->User_Model->faceS($photoid)?>" /></a></div></div><div class="right"><div class="info">
<?php
   $ok_skills=false;
   if(($logid==$uid&&is_numeric($uid))||(is_numeric($ok_uid)&&$ok_uid==$uid)){
	   $ok_skills = $skills;
   }else{
	   $ok_skills = false;
   }
?>
<div class="title"><a href="<?php echo site_url("/user/".$uid)?>?rid=<?php echo $ers->id?>" target="_blank"><?php echo $this->User_Model->name($ers->uid)?></a><?php if($ok_skills==false){echo " 已参与竞标，中标后公布报价"; }else{echo " 的报价为：".$ok_skills;}?></div></div>
<?php if($ers->show==1){?><div class="note"><?php echo $ers->note?></div><?php }else{?><div class="note" style="color:#999">留言已隐藏...</div><?php }?></div>
<?php if(!empty($RUid)&&$RUid!=""&&is_numeric($RUid)){?><div class="order_to"><span style="width:auto;" class="tip" title="下单给该工人!"><span class="content" style="width:auto; background-color:#F00"><span class="info_edit" style="width:auto;"><a style="display:none;" class="yz_buy" userid="<?php echo $ers->uid?>" rid="<?php echo $ers->id?>" href="javascript:void(0);">&nbsp;</a></span></span></span></div><?php }?>
<div class="clear"></div></div></div></div><?php }?>
<div class="clear"></div><div><?php $this->paging->links(); ?></div>
<?php }else{?><div class="content_box">暂时没有相关投标信息!</div><?php }?> 

</div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>