<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content">   <table width="100%" border="0" cellpadding="5" cellspacing="0"><tr><td colspan="7" class="yzpage_line"></td></tr><?php if(!empty($list)){
	foreach($list as $rs){?><tr class="edit_item_tr"><td width="40" valign="top"><span class="chenghong2">消息：</span><a href="<?php echo $rs->id?>" class="sendmsg_del_id"></a></td><td valign="top"><?php echo $rs->content?></td>
      <td width="100" align="center" valign="top"><span class="time"><?php echo dateYMD($rs->addtime)?></span></td>
      <td width="30" align="center" valign="top">
      <a href="<?php echo reUrl('del_id='.$rs->id)?>" class="item_del" title="删除该消息"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
      </td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="7" class="edit_item_none">暂无信息</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }?></table></div>
<?php $this->Paging->links(); ?><div class="clear"></div></div></div></div>
<!--清除浮动--><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>