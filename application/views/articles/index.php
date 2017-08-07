<?php $this->load->view('public/header'); ?><script language="javascript" type="text/javascript"><?php /*?>初始化、绑定右边工人tab事件<?php */?>
$(function(){
$(".recommendbox .tab_top").find("a").eq(0).attr("class","on");
$(".recommendbox").find(".tab").eq(1).css({display:"block"});
});</script></head><body><?php $this->load->view('public/top');?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box">
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="10">
<tr><td valign="top" class="page_main_title"><div>装修学堂</div><p class="page_main_line">&nbsp;</p></td></tr>
<tr><td height="400" valign="top" class="page_main_content">
<table width="100%" border="0" align=center cellpadding=0 cellspacing=0 class="forum">	  
<?php if(!empty($list)){?><?php foreach ($list as $rs){?><tr><td width="80" height="30" align="center" bgcolor="#FFF8E8" style="font-size:13px;"><a href="<?php echo site_url("articles/type/".$rs->t_id)?>"><?php echo $rs->t_title?></a></td><td width="12" align="left" bgcolor="#FFF8E8" style="font-size:13px;"><img src="<?php echo $img_url?>ico/yline.gif" width="1" height="12" /></td><td bgcolor="#FFF8E8" style="font-size:13px;"><a href="<?php echo site_url("articles/view/".$rs->id)?>" target="_blank"><?php echo $rs->title?></a></td><td width="80" align="center" bgcolor="#FFF8E8" title=""><?php echo date("Y-m-d",strtotime($rs->time))?></td></tr><tr><td colspan="4" align="center" style="height:1px; line-height:1px; border-top:#999 1px dotted;"></td></tr><?php }}else{?><tr><td colspan="4" align="center" height="50">暂无相关内容...</td></tr><?php }?>
<tr><td height="20" colspan="5" align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="32" align="center">
<?php $this->Paging->links(); ?>
</td></tr></table></TD></tr></table></td></tr></table></div></div>
<div class="index_right"><div class="right_box">
<div class="recommendbox"><div class="tab_title">学堂分类</div><div class="clear"></div><div class="tab_box" id="help_but"><div class="tab" style="display:block; background-image:url(<?php echo $img_url?>ico/num.gif);"><?php if(!empty($type)){?><?php foreach($type as $rs){?><li><dd><a href="<?php echo site_url("articles/type/".$rs->t_id)?>"><?php echo $rs->t_title?></a></dd></li><?php }?><?php }?><div class="clear"></div></div></div><div class="clear"></div></div>
<?php $this->load->view('public/mod_yxb');?>
<div class="right_ad"><a href="javascript:void(0);"><img src="<?php echo $img_url?>ads/index_ad.jpg" /></a></div> </div></div><!--清除浮动--><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>