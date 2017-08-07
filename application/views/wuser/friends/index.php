<?php $this->load->view('public/header'); ?>
<?php /*?>推荐好友<?php */?><script language="javascript" type="text/javascript"> 
$(function(){
  $(".recommend").click(function(){
	   var id=$(this).attr("id");
	   tb_show('推荐好友','<?php echo site_url($c_urls."/recommend_edit")?>?height=180&width=320&fuid='+id,false);
	  });
});</script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist"><td align="left">&nbsp;用户</td><td width="200" align="center">添加时间</td><td width="100" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="left">
&nbsp;<?php echo $this->User_Model->links($rs->fuid);?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><a href="<?php echo reUrl('cmd=del&id='.$rs->id)?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
&nbsp;&nbsp;<?php if($this->Recommend_Model->is_Recommend($logid,$rs->fuid)){?><img src="<?php echo $img_url?>ico/tick_circle.png" width="16" height="16" class="tip" title="已推荐" /><?php }else{?><a href="javascript:void(0);" id="<?php echo $rs->fuid?>" class="recommend tip" title="推荐后可以在个人主页上显示">推荐</a><?php }?>
<?php /*?>&nbsp;&nbsp;<a href="<?php echo reUrl('cmd=black&id='.$rs->id)?>" class="tip" title="把他拉到黑名单，以免骚扰！">拉黑</a><?php */?></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div><?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>