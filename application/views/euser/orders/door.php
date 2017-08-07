<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'od');?>

<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
<td width="120" align="left">&nbsp;用户信息</td>
<td align="left">单号</td>
<td width="80" align="center">费用(元)</td>
<td width="110" align="center">下单时间</td>
<td width="50" align="center">状态</td>
<td width="130" align="center">操作</td></tr><tr><td colspan="9" class="yzpage_line"></td></tr>
<?php
if(!empty($list)){
	foreach($list as $rs){
	  //获取当前订单的状态(是否完成)
	  $ostat = $this->Orders_Model->order_door_stat($rs->id);
	  //订单评分状态
	  $isevaluate = $this->Common_Model->isevaluate_order_door($rs->id,$logid);
	  $order_stat_btu = order_stat($ostat,$isevaluate,$rs->id);
?>
<tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->uid_2);?></td>
<td align="left"><?php echo $rs->orderid?></td>
<td align="center" class="chenghong"><?php echo $rs->cost?></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center"><?php echo $order_stat_btu;?></td>
<td align="center">
<?php ajax_url('下新订单',$c_url.'orders_select/index/'.$rs->uid_2);?> &nbsp; <?php ajax_url('详情',$c_urls.'/view/'.$rs->id);?>
</td></tr><tr><td colspan="9" class="yzpage_line"></td></tr>
<?php }}else{?><tr><td colspan="9" align="center">暂无上门单信息</td></tr><tr><td colspan="9" class="yzpage_line"></td></tr><?php }?></table>
<div class="clear"></div></div>
<div id="center_paging"><?php $this->paging->links(); ?></div>
<div class="clear"></div>
</div></div>