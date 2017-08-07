<script language="javascript" type="text/javascript">
$(function(){
	$('.edit_box_order_project').hover(
	     function(){$(this).attr('class','edit_box_order_project_hover');},
	     function(){$(this).attr('class','edit_box_order_project');
		 });
 });
</script>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'op');?>

<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"><?php echo Get_User_Nav($thisnav,$c_url); ?></div>
<div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content">
<?php
if(!empty($list)){
  foreach($list as $rs){
	  #获取当前合同的状态(是否完成)
	  $ostat = $this->Orders_Model->order_project_stat($rs->id);
	  #订单评分状态
	  $isevaluate = $this->Common_Model->isevaluate_order_project($rs->id,$logid);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="edit_box_order_project"><tr><td>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
<tr class="edit_item_frist_bg"><td width="135">&nbsp;<?php echo $this->User_Model->links($rs->uid);?></td>
<td width="225">订单编号：<a href="<?php echo site_url($c_urls.'/view/'.$rs->id);?>"><?php echo $rs->orderid?></a></td><td width="80" align="left"><span class="chenghong"><?php echo $this->Orders_Model->order_project_allprice($rs->id)?></span> 元</td><td align="left">下单时间：<?php echo dateHi($rs->addtime)?></td>
<td width="80" align="center" class="diy_link_but"><a href="<?php echo site_url($c_urls.'/view/'.$rs->id)?>" target="_blank" >订单详情</a></td>
</tr>
<tr>
<td height="50" colspan="5" valign="top" class="edit_item_frist_line">
<table width="100%" border="0" cellpadding="0" cellspacing="1">
<tr><td height="50" valign="top">订单描述：<?php echo $rs->note?></td>
<td width="80" align="center" valign="middle">
<?php echo order_stat($ostat,$isevaluate,$rs->id);  /*?>订单状态<?php */ ?>
</td>
</tr></table></td></tr></table>
</td></tr></table>

<?php }}else{ echo '暂无信息!'; }?>

<div class="clear"></div>
</div>
<?php $this->paging->links(); ?>
<div class="clear"></div>
</div></div>