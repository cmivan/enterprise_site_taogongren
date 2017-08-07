<?php $this->load->view('public/header'); ?>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'od');?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>
<div class="my_right"><div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"><?php echo c_nav($thisnav,$c_url); ?></div>
<div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td width="120" align="left">&nbsp;下单用户</td>
  <td align="left">单号</td>
  <td width="80" align="center">费用(元)</td>
  <td width="110" align="center">下单时间</td>
  <td width="50" align="center">状态</td>
  <td width="60" align="center">操作</td></tr><tr><td colspan="9" class="yzpage_line"></td></tr>
<?php
if(!empty($list)){
	foreach($list as $rs){
	  #获取当前订单的状态(是否完成)
	  $ostat = $this->Orders_Model->order_door_stat($rs->id);
	  #订单评分状态
	  $isevaluate = $this->Common_Model->isevaluate_order_door($rs->id,$logid);
	  $order_stat_btu = order_stat($ostat,$isevaluate,$rs->id);
?>
<tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->uid);?></td>
  <td align="left"><a href="<?php echo site_url($c_urls.'/view/'.$rs->id)?>" title=" 查看该订单详情!  " ><?php echo $rs->orderid?></a></td>
  <td align="center" class="chenghong"><?php echo $rs->cost?></td>
  <td align="center"><?php echo dateHi($rs->addtime)?></td>
  <td align="center"><?php echo $order_stat_btu;?></td>
  <td align="center"><a href="<?php echo site_url($c_urls.'/view/'.$rs->id)?>">详情</a></td></tr><tr><td colspan="9" class="yzpage_line"></td></tr>
<?php }}else{?><tr><td colspan="9" align="center">暂无信息</td></tr><tr><td colspan="9" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>