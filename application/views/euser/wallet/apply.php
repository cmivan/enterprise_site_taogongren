<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main">
<!--管理页面的框架分布--><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>

<div class="my_right"><div class="mainbox" box="content_box">
<?php /*?>钱包页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?><div class="info">
&nbsp;&nbsp; 淘工币：<label class="chenghong"><?php echo $cost_T?></label> 个
&nbsp;&nbsp; 现金账户：<label class="chenghong"><?php echo $cost_S?></label> 元</div></div>
<div class="mainbox_box"><div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="40" align="center">编号</td>
  <td>&nbsp;说明</td>
  <td width="64" align="center">金额</td>
  <td width="120" align="center">时间</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><?php if($rs->costype=="T"){$costype="淘工币";}else{$costype="元";}?><tr class="edit_item_tr">
  <td align="center"><?php echo $rs->id?></td>
  <td><?php if($rs->costype=="S_XY"){echo '<img src="views/images/ico/xin.gif" />';}?>&nbsp;&nbsp;<?php echo $rs->note?></td>
  <td align="center"><span class="chenghong"><?php echo $rs->cost?></span> <?php echo $costype?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php
}}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><?php }?></table>


<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>