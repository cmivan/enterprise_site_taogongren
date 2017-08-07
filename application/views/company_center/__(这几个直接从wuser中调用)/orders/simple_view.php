<?php $this->load->view('public/header'); ?>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'os');?>

<script language="javascript" type="text/javascript">
$(function(){
	<?php /*?>同意收款款项<?php */?>
	$("a.ok_yes").click(function(){
	   var thisid = $(this).parent().parent().attr("id");
	   tb_show('请认真查看并选择','<?php echo site_url($c_urls.'/simple_ok')?>?height=105&width=260&sid='+thisid,false);
	});
	<?php /*?>不同意收款<?php */?>
	$("a.ok_not").click(function(){
	   var thisid = $(this).parent().parent().attr("id");
	   tb_show('填写不同意业主申请的原因','<?php echo site_url($c_urls.'/simple_not_msg')?>?height=95&width=300&id='+thisid,false);	
	});
 });
</script>

</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>
<div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?>
<div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div>
<div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?><div class="content"><br><table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php
if(!empty($view)){
	  #获取当前合同的状态(是否完成)
	  $ostat = $this->Orders_simple_Model->order_stat($view->id);
	  #订单评分状态
	  $isevaluate = $this->Common_Model->isevaluate_order_simple($view->id,$logid);
?>
<tr><td align="left">
<table width="99%" border="0" cellpadding="3" cellspacing="0"><tr><td align="left">&nbsp;&nbsp;<span style="text-decoration:underline">单号：<?php echo $view->orderid?></span></td><td width="100" align="right">费用：<span class="chenghong"><?php echo $view->cost?></span> 元</td><td width="80" align="center"><?php echo dateYMD($view->addtime)?></td>
<td width="40" align="center">
<?php echo order_stat($ostat,$isevaluate,$view->id);  /*?>订单状态<?php */ ?>
</td>

<?php /*未互评则可以继续不加订单*/
if($isevaluate!=2){?>
<td width="72" class="diy_link_but"><a href="<?php echo site_url($c_urls.'/patch/'.$view->id)?>" style="font-weight:lighter">添加补单</a></td>
<?php }?>

</tr></table>

<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td width="90" align="center">下单人</td><td align="left"> &nbsp;订单描述</td><td width="60" align="center">费用(元)</td><td width="50" align="center">保修期</td><td width="80" align="center">下单时间</td><td width="90" align="center">操作</td></tr>
            <tr class="edit_item_tr"><td style="padding:5px;"><?php echo $this->User_Model->links($view->uid)?></td>
<td align="left" style="padding:5px;"><?php echo $view->note?></td><td align="center"><span class="chenghong"><?php echo $view->cost?></span></td><td align="center"><?php if($view->bx_time!=''){echo $view->bx_time;}else{echo '-';}?></td>
            <td align="center"><?php echo dateYMD($view->addtime)?></td><td align="center" id="<?php echo $view->id?>"><div class="edit_but"><?php simple_stat_W($view->ok,$view->refund_ok,$view->refund);?></div></td></tr>

<?php if(!empty($view_step)){?><tr class="edit_item_frist"><td align="center">补单人</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php foreach($view_step as $vrs){?><tr class="edit_item_tr"><td style="padding:5px;"><?php echo $this->User_Model->links($vrs->w_uid)?></td><td align="left" style="padding:5px;"><?php echo $vrs->note?></td><td align="center"><span class="chenghong"><?php echo $vrs->cost?></span></td><td align="center"><?php if($vrs->bx_time!=''){echo $vrs->bx_time;}else{echo '-';}?></td><td align="center"><?php echo dateYMD($vrs->addtime)?></td><td align="center" id="<?php echo $vrs->id?>"><div class="edit_but"><?php simple_stat_W($vrs->ok,$vrs->refund_ok,$vrs->refund);?></div></td></tr><?php }}?></table></td></tr><?php }else{?><tr><td height="50" align="center">暂无信息</td></tr><?php }?></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>