<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width">
<div class="body_main"><?php /*?>管理页面的框架分布<?php */?>
<div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?>
<div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr class="edit_item_frist">
  <td align="left">&nbsp;团队名称</td>
  <td align="center">团队人数</td>
  <td width="200" align="center">加入时间</td>
  <td width="80" align="center">操作</td></tr>
  <tr><td colspan="7" class="yzpage_line"></td></tr>
  <?php if(!empty($list)){?><?php foreach($list as $rs){?>
  <tr class="edit_item_tr"><td align="left">&nbsp;<?php echo $this->User_Model->links($rs->id);?></td>
    <td align="center"><?php echo g_team_num($row["id"])?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center"><a href="<?php echo $rs->id?>" class="favorites_del_id"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a></td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr><td colspan="7" align="center">暂无信息</td></tr>
  <?php }?></table>
<div class="clear"></div></div>
<?php $this->Paging->links(); ?>
<div class="clear"></div>
</div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>