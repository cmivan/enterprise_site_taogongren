<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content">   <table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist"><td align="center" valign="top">称呼</td><td align="center" valign="top">性别</td><td align="center">手机</td><td align="center">QQ</td><td align="center">邮箱</td><td width="80" align="center">介绍时间</td><td width="80" align="center">操作</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr">
  <td align="center"><?php echo $rs->nicename?></td>
  <td align="center"><?php echo $rs->sex?></td>
  <td align="center"><?php echo $rs->mobile?></td>
  <td align="center"><?php echo $rs->qq?></td>
  <td align="center"><?php echo $rs->email?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center">

<a href="<?php echo site_url($c_urls)."?del_id=".$rs->id?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">修改</a>
</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="8" class="edit_item_none">暂无信息</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr><?php }?></table>
<div class="clear"></div></div><?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>