<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> <div class="info">
&nbsp;&nbsp; 淘工币：<label class="chenghong"><?php echo $cost_T?></label> 个
&nbsp;&nbsp; 现金账户：<label class="chenghong"><?php echo $cost_S?></label> 元</div></div>
<div class="mainbox_box"><div class="content">   <table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="34" align="center">编号</td>
  <td width="42" align="center">类型</td>
  <td width="68" align="center">金额(元)</td>
  <td width="60" align="center">状态</td>
  <td width="223">&nbsp;帐号信息</td>
  <td width="124" align="center">提交时间</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr">
  <td align="center"><?php echo $rs->id?></td>
  <td align="center"><?php if($rs->typeid==1){echo "转账";}else{echo "提现";}?></td>
  <td align="center"><?php echo $rs->cost?></td>
  <td align="center"><?php
$stat=$rs->stat;
if($stat==0){
	echo "<span class=chenghong2>未处理</span>";
}elseif($stat==1){
	echo "<span class=green>已处理</span>";
}elseif($stat==2){
	echo "<span class=red>处理失败</span>";
}
?></td><?php
  $cardnum=$rs->cardnum;
  $cardlen=strlen($cardnum);
  $cardnum=substr_replace($cardnum,"*******",5).substr($cardnum,$cardlen-6,6);
?>
  <td><span class="tip" title="开户行：<?php echo $rs->cardat?><br/>卡号：<?php echo $cardnum;?><br/>"><?php echo $rs->cardat?>、<?php echo $cardnum;?></span></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php
}}else{?><tr class="edit_item_tr"><td colspan="10" class="edit_item_none">暂无信息</td></tr><?php }?></table></div>
<?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>