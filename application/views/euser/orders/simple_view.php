<?php $this->load->view('public/header'); ?>
<style>
.edit_but{position:relative;width:110px;overflow:hidden;}
#monery{width:90px;}
.tuikuanbox{position:relative;z-index:999;}
.tuikuanbox .tuikuan{position:absolute;left:-98px;top:-36px;background-color:#FFFACD;border:#555 2px solid;border-bottom:#000 4px solid;display:none;}
.tuikuanbox .tuikuan td{background-color:#FFFACD; text-align:center;}
.tuikuanbox .tip{color:#F00;text-align:center;}
#cost_close{float:right;width:13px;height:13px;line-height:13px;cursor:pointer;background-image:url(<?php echo $img_url?>ico/button.gif);background-position:-248px -102px;background-repeat:no-repeat;}
#cost_close:hover{ background-position:-302px -102px; }
#cost_close img{visibility:hidden; widows:13px; height:13px;}
.Tboxs{ color:#F00; }</style>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'os');?>

<script language="javascript" type="text/javascript">
$(function(){
	<?php /*?>订单操作-申请验收<?php */?>
	$(".ok").click(function(){
	   alert("建议在申请验收前先双方协商一致！");
	   var thisid=$(this).parent().attr("id"); <?php /*?>隐藏以显示的申请框<?php */?>
	   $(this).parents().find(".tuikuan").fadeOut(200); <?php /*?>显示选择的申请框<?php */?>
	   $(this).parent().parent().parent().find(".tuikuan").fadeIn(200);
	});
	<?php /*?>由工人添加的补单信息-工人确定并验收该内容<?php */?>
	$(".ok_order").click(function(){
	   var thisid=$(this).parent().parent().attr("id");
	   if(confirm("如果你确定同意工人所写的订单内容\r\n系统将会把相应的费用和本次订单费用的5%\r\n从你帐户上扣除并暂时支付到平台！")){
		  $(this).attr("href","?action=ok_order&v_id="+thisid);
	   }
	});
	<?php /*?>提交申请<?php */?>
	$(".form_send").click(function(){
	   var thisObj   =$(this).parent().parent().parent();
	   var monery    =thisObj.find("#monery").val();
	   var monery_max=thisObj.find("#monery_max").val();
	   var thisForm  =$(this).parent().parent().parent().parent().parent().parent().parent().parent();
	   if(monery!=parseInt(monery)){
		  thisObj.find(".Tboxs").text("要求验收金额应为正整数！");
		  thisObj.find(".Tboxs").fadeOut(200).fadeIn(200);
		  return false;
	   }else if(parseInt(monery)<0){
		  thisObj.find(".Tboxs").text("请填写正确的验收金额！");
		  thisObj.find(".Tboxs").fadeOut(200).fadeIn(200);
		  return false;
	   }else if(parseInt(monery)>parseInt(monery_max)){
		  thisObj.find(".Tboxs").text("验收金额不能大于 "+monery_max+" 元!");
		  thisObj.find(".Tboxs").fadeOut(200).fadeIn(200);
		  return false;
	   }else{
		  thisObj.find(".Tboxs").text("正在提交...");
		  thisForm.find(".form_back").submit();
		  return false;
	   }
	});
	<?php /*?>关闭窗口<?php */?>
	$(".tuikuan .close").click(function(){ $(this).parents().find(".tuikuan").fadeOut(200); });
	<?php /*?>订单操作-申诉<?php */?>
	$("a.feed_yes").click(function(){
	   var thisid=$(this).parent().parent().attr("id");
	   JqueryDialog.Open1('&nbsp;&nbsp;意见反馈!', 'user-feedback.php<?php echo reUrl("action=feed_yes&id=")?>'+thisid,400, 330, false, false, true);
	});
		
		
	  //订单操作-不申诉
//        $("a.feed_not").click(function(){
//		   var thisid=$(this).parent().parent().attr("id");
//		   if(confirm('确认不再追究这个事情吗？')){
//			  $(this).attr("href","?o_id=<?php//=$o_id?>&action=feed_not&id="+thisid);
//			  return true;
//		   }else{
//			  return false;
//		   }
//		});


 });</script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?><div class="content"><br><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
            <td align="center"><?php echo dateYMD($view->addtime)?></td><td align="center" id="<?php echo $view->id?>"><div class="tuikuanbox"><div class="tuikuan"><table border="0" cellpadding="2" cellspacing="1"><tr><td colspan="4" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>请填写验收支付的金额(元)</td><td width="20" align="center"><a href="javascript:void(0);" id="cost_close" class="close">&nbsp;</a></td></tr></table></td></tr><form action="?action=ok&v_id=<?php echo $view->id?>" method="post" class="form_back"><tr><td><input type="text" name="monery" id="monery" /></td><td><a class="form_send" href="javascript:void(0);">提交</a></td></tr><input type="hidden" name="monery_max" id="monery_max" value="<?php echo $view->cost?>" /><tr><td colspan="2" class="Tboxs"></td></tr></form></table></div></div><div class="edit_but"><?php simple_stat_E($view->ok,$view->refund_ok,$view->refund,$view->msg);?></div></td></tr>
<?php if(!empty($view_step)){?><tr class="edit_item_frist"><td align="center">补单人</td><td>&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr>
<?php foreach($view_step as $vrs){?><tr class="edit_item_tr"><td style="padding:5px;"><?php echo $this->User_Model->links($vrs->w_uid)?></td><td align="left" style="padding:5px;"><?php echo $vrs->note?></td><td align="center"><span class="chenghong"><?php echo $vrs->cost?></span></td><td align="center"><?php if($vrs->bx_time!=''){echo $vrs->bx_time;}else{echo '-';}?></td><td align="center"><?php echo dateYMD($vrs->addtime)?></td><td align="center" id="<?php echo $vrs->id?>"><div class="tuikuanbox"><div class="tuikuan"><table border="0" cellpadding="2" cellspacing="1"><tr><td colspan="4" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>请填写验收支付的金额(元)</td><td width="20" align="center"><a href="javascript:void(0);" id="cost_close" class="close">&nbsp;</a></td></tr></table></td></tr><form action="?action=ok&v_id=<?php echo $vrs->id?>" method="post" class="form_back"><tr><td><input type="text" name="monery" id="monery" /></td><td><a class="form_send" href="javascript:void(0);">提交</a></td></tr><input type="hidden" name="monery_max" id="monery_max" value="<?php echo $vrs->cost?>" /><tr><td colspan="2" class="Tboxs"></td></tr></form></table></div></div><div class="edit_but"><?php simple_stat_E($vrs->ok,$vrs->refund_ok,$vrs->refund,$vrs->msg);?></div></td></tr><?php }}?></table></td></tr><?php }else{?><tr><td height="50" align="center">暂无信息</td></tr><?php }?></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>