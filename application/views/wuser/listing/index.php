<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td colspan="2" align="left">&nbsp;简述</td>
  <td width="150" align="center">添加时间</td>
  <td width="100" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td colspan="2"><?php echo $rs->note?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><a href="<?php echo site_url($c_urls)."?del_id=".$rs->id?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div>
<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>