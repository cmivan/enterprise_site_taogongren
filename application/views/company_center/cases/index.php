<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<div class="content">
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tr class="edit_item_frist"><td align="center">案例</td><td width="350" align="center">&nbsp;案例名称</td><td width="120" align="center">添加时间</td><td width="70" align="center">操作</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr>
<?php if(!empty($list)){
	foreach($list as $rs){
		$pic = img_cases($rs->pic);
?><tr class="edit_item_tr"><td align="center"><div style="width:150px; overflow:hidden" title="点击查看大图" class="tip" ><a href="<?php echo $pic?>" target="_blank"><img src="<?php echo $pic?>" name="photo" height="20" border="0" id="photo"></a></div></td><td align="center">&nbsp;
  <?php echo $rs->title?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><a href="<?php echo site_url($c_urls)."?del_id=".$rs->id?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" class="tip" title="删除该案例" /></a>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">修改</a></td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="7" class="edit_item_none">暂无信息</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }?>
</table><div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>