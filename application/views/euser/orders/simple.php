<?php $this->load->view('public/header'); ?>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'os');?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td width="120" align="left">&nbsp;下单用户</td>
  <td align="left">订单描述</td>
  <td width="110" align="center">下单时间</td>
  <td width="60" align="center">状态</td>
  <td width="80" align="center">操作</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr>
<?php
if(!empty($list)){
foreach($list as $rs){
	  #获取当前合同的状态(是否完成)
	  $ostat = $this->Orders_Model->order_simple_stat($rs->id);
	  #订单评分状态
	  $isevaluate = $this->Common_Model->isevaluate_order_simple($rs->id,$logid);
?>
<tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->uid);?></td><td align="left"><?php echo cutstr($rs->note,17)?></td><td align="center"><?php echo dateHi($rs->addtime)?></td><td align="center"><?php echo order_stat($ostat,$isevaluate,$rs->id)?></td><td align="center">
<?php if($isevaluate==2){?>
<span style="text-decoration:line-through;color:#999">补单</span>
<?php }else{?>
<a href="<?php echo site_url($c_urls.'/patch/'.$rs->id)?>">补单</a>
<?php }?>
&nbsp;<a href="<?php echo site_url($c_urls.'/view/'.$rs->id)?>">详情</a></td></tr><tr><td colspan="8" class="yzpage_line"></td></tr><?php }}else{?><tr><td colspan="8" align="center">暂无简化单信息</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr><?php }?></table>
<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div></div>
<div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>