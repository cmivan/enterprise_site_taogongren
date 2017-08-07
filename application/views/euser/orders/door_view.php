<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'od');?>

<script language="javascript" type="text/javascript">
$(function(){
	//订单操作-确认付款
	$("a.ok").click(function(){
	   var thisid=$(this).parent().attr("id");
	   if(confirm('确认付款后本次上门费用将直接打到相应的工人账户上!是否确认付款？')){
		  $(this).attr("href","?action=ok&id="+thisid);
		  return true;
	   }else{
		  return false;
	   }
	});
	//订单操作-申请退款
	$("a.back").click(function(){
	   var thisid=$(this).parent().attr("id");
	   if(confirm('确认向对方发出申请退款？')){
		  $(this).attr("href","?action=back&id="+thisid);
		  return true;
	   }else{
		  return false;
	   }
	});
	//订单操作-取消追究
	$("a.cancel").click(function(){
	   var thisid=$(this).parent().attr("id");
	   if(confirm('确认不再追究该上门单的费用吗？')){
		  $(this).attr("href","?action=cancel&id="+thisid);
		  return true;
	   }else{
		  return false;
	   }
	});
	//订单操作-申请
	$("a.feed").click(function(){
	   var thisid=$(this).parent().attr("id");
	   if(confirm('确认要发起申诉，要求网站客服介入吗？')){
		  $(this).attr("href","?action=feed&id="+thisid);
		  return true;
	   }else{
		  return false;
	   }
	});
});
</script>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php if(!empty($view)){?>
<tr><td height="450" align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" style="margin-bottom:3px;"><tr><td width="100" align="left"><?php echo $this->User_Model->links($view->uid)?></td><td align="left">&nbsp;&nbsp;<span style="text-decoration:underline">单号：<?php echo $view->orderid?></span></td><td width="100" align="right">费用：<span class="chenghong"><?php echo $view->cost?></span> 元</td><td width="80" align="center"><?php echo dateYMD($view->addtime)?></td><td width="40" align="center">
<?php echo $order_stat_btu;  /*?>订单状态<?php */ ?>
</td><td width="60" class="diy_link_but"><a href="<?php echo site_url($c_urls);?>" style="font-weight:lighter">返回</a></td>  </tr>
</table><table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;" id="<?php echo $view->id?>"><tr class="edit_item_frist"><td colspan="3" align="left" style="padding-left:12px;">订单信息</td></tr>
<tr class="edit_item_tr"><td height="60" colspan="3" align="left" valign="top" style="padding:12px;"><span class="red">地址：<?php echo $view->place?></span><br /><?php echo $view->note?></td></tr><tr class="edit_item_frist"><td align="left" style="padding-left:12px;">步骤描述</td><td width="200" align="center">时间</td><td width="200" align="center">状态</td></tr><?php

$stepAll = $this->Orders_Model->order_door_steps($view->id);
$stepNums= 0;

if(!empty($view_step)){
foreach($view_step as $vrs){
  $thisstep = $stepAll - $stepNums;
  $stepNums++;
  $steptime = $vrs->steptime;
?>
        <tr class="edit_item_tr"><td align="left" style="padding-left:12px;"><?php echo $vrs->stepnote?></td><td width="200" align="center"><?php echo $vrs->steptime?></td><td width="200" align="center" id="<?php echo $vrs->id?>"><?php
#控制按钮状态
if($vrs->ok==0){
	
switch($thisstep){
	 case 1:
	   date7day($steptime,"<a href='javascript:void(0);' class=back>申请退款</a>&nbsp;|&nbsp;<a href='javascript:void(0);' class=ok>确认付款</a>");
	   break;
	 case 2:
	   date7day($steptime,"等待工人回应...");
	   break;
	 case 3:
	   date7day($steptime,"<a href='javascript:void(0);' class=cancel>取消追究</a>&nbsp;|&nbsp;<a href='javascript:void(0);' class=feed>我要申诉</a>");
	   break;
	 case 4:
	   date7day($steptime,"等待网站客服介入...");
	   break;
	}
}else{
	if($vrs->isend==0){
	  echo '<span class=green>-</span>'; //步骤已完成 未结算
	}else{
	  echo '<span class=red>已结算</span>'; //步骤已完成 已结算 
	}
}
?></td></tr><?php }}?></table></td></tr>
<?php }else{?><tr><td height="250" align="center">暂无信息</td></tr><?php }?></table><div class="clear"></div></div></div></div>