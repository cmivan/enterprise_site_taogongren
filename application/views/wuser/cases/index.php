<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?></div>
<div class="mainbox_box"><div class="content">

<?php if(!empty($worker_types)){?>
<table border="0" cellpadding="0" cellspacing="3"><tr class="edit_nav_2">
<?php foreach($worker_types as $wt_item){?>
<td align="center">
<a href="<?php echo site_url($c_urls."/index/".$wt_item->id)?>" <?php if($is_team==$wt_item->id){echo 'class="on"';}?>>
<?php echo $wt_item->title?>案例
</a></td>
<?php }?>
</tr></table>
<?php }?>

<table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist"><td>&nbsp;标题</td><td width="120" align="center">添加时间</td><td width="80" align="center">操作</td></tr><tr align="center"><td height="1" colspan="5" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td>&nbsp;<?php echo $rs->title?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><a href="?del_id=<?php echo $rs->id?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?>
</table><div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>