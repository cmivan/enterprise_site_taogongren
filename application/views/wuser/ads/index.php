<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1" >
<tr class="edit_item_frist"><td align="left" valign="top">&nbsp;广告语</td><td width="60" align="center">费用(元)</td><td width="80" align="center" valign="top">开始日期</td><td width="80" align="center">结束日期</td><td width="40" align="center">状态</td><td width="80" align="center">操作</td></tr><tr align="left"><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr">
  <td align="left">&nbsp;<?php echo $rs->ad?></td>
  <td align="center"><strong class="chenghong"><?php echo $rs->cost?></strong></td>
  <td align="center">
  <?php echo $rs->s_date?></td>
  <td align="center"><?php echo $rs->e_date?></td>
  <td align="center"><?php 
$dateYmd = date('Y-m-d',time());
$is_S = $this->TeamAd_Model->ads_isok($rs->s_date,$dateYmd);
$is_E = $this->TeamAd_Model->ads_isok($dateYmd,$rs->e_date);
if($is_S){if($is_E){echo '<span class=red>进行中</span>';}else{echo '<span class=green>已结束</span>';}}else{echo '未开始';}

?>
  </td>
  <td align="center"><a href="<?php echo site_url($c_urls."/del/".$rs->id)?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="8" class="edit_item_none">暂无信息</td></tr><?php }?>
</table>

<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>