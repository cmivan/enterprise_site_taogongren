<?php $this->load->view('public/header'); ?>
<?php $this->load->view('public/header_my'); ?>

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
	<?php /*?>显示评价框<?php */?>
	$(".order_comm").click(function(){
	   var orderid=$(this).attr("id");				
	   JqueryDialog.Open1('&nbsp;&nbsp;给工人评价打分!', 'user-works-common-add.php?mob=simple&oid='+orderid,600, 368, false, false, false);
	});	
 });
</script>

</head>
<body>
<?php $this->load->view('public/top'); ?>

<div class="main_width">
<div class="body_main">
<?php /*?>管理页面的框架分布<?php */?>
<div class="my_left"><div class="my_left_nav">
<?php $this->load->view($c_url.'leftnav'); ?>
<div class="clear"></div></div></div>

<div class="my_right">
<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?>
<div class="mainbox_nav">
<?php
if(!empty($thisnav)){
	if(!empty($thisnav["nav"])){
	foreach($thisnav["nav"] as $nav){
?>
<a href="<?php echo site_url($c_url.$nav["link"])?>" <?php if($thisnav["on"]==$nav["link"]){echo "class=on";}?> ><?php echo $nav["title"]?></a>
<?php }}}?>
</div>

<div class="mainbox_box">
<?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php
if(!empty($view)){
   #<><><>获取当前合同的状态(是否完成)
   $ostat = $this->Orders_Model->order_simple_stat($view->id);
   #<><><>判断是否已经添加评价
   $isevaluate = $this->Orders_Model->order_simple_comm($view->id,$logid);
?>
<tr><td align="center">
<table width="100%" border="0" cellpadding="3" cellspacing="0">
<tr><td align="left"><?php echo $user_links?>&nbsp;&nbsp;&nbsp;&nbsp;
<span style="text-decoration:underline">单号：<?php echo $view->orderid?></span></td>
  <td width="150" align="left">下单时间：
    <?php echo dateYMD($addtime)?></td>
<td width="30" align="center"><?php echo order_stat($ostat,$isevaluate,$view->id)?></td>
<td width="72" align="center" class="diy_link_but"><a href="javascript:history.go(-1);">返回</a></td>
</tr></table>

<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist">
<td align="left">&nbsp;一、订单基本要求</td>
<!--<td width="60" align="center">费用(元)</td>-->
</tr>          
<tr class="edit_item_tr">
<td align="left" style="padding:10px;"><?php echo $note?></td>
<!--<td align="center"><?php echo $allprice?></td>-->
</tr></table>


<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist"><td width="140" colspan="9" align="left"> &nbsp;二、工程报价单</td></tr>          

<?php if(!empty($price_view)){?>
<tr>
  <TD width="65" align="middle">编号</TD>
  <TD align="middle">项目</TD>
  <TD width="45" align="center">数量</TD>
  <TD width="45" align="center">单位</TD>
  <TD width="80" align="center">人工单价(元)</TD>
  <TD width="80" align="center">材料单价(元)</TD>
  <TD width="50" align="center">合计(元)</TD>
  <TD width="50" align="center">状态</TD>
  <TD width="75" align="center">操作</TD>
</tr>

<?php foreach($price_view as $pvrs){?>
<tr class="edit_item_tr">
  <TD  align="middle"><?php echo $pvrs->id?></TD>
  <TD align="middle"><?php echo $pvrs->project?></TD>
  <TD  align="center"><?php echo $pvrs->num?></TD>
  <TD  align="center"><?php echo $pvrs->units?></TD>
  <TD width="80"  align="center"><?php echo $pvrs->r_price?></TD>
  <TD width="80"  align="center"><?php echo $pvrs->c_price?></TD>
  <TD width="50"  align="center"><?php echo ($pvrs->r_price+$pvrs->c_price)*$pvrs->num?></TD>
  <TD width="50"  align="center"><?php echo $this->Orders_Model->prostat($pvrs->u_ok);?></TD>
  <TD  align="center"><?php echo $this->Orders_Model->prostat($pvrs->u_ok,1);?></TD>
</tr>
<?php }}else{?>
<tr class="edit_item_tr"><TD height="60" colspan="9"  align="center"><a href="javascript:void(0);">请添加项目报价</a></TD></tr>
<?php }?>

</table>


<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist"><td colspan="5" align="left"> &nbsp;三、 合同信息</td></tr> 

<?php if(!empty($deal_view)){?>        
<tr>
  <TD align="middle">项目名称</TD>
  <TD width="85" align="middle">交易金额</TD>
  <TD width="100" align="center">合同状态</TD>
  <TD width="75" align="center">当前可操作</TD>
  <TD width="75" align="center">流程指引</TD>
</tr>
<tr class="edit_item_tr">
  <TD  align="middle"><a href="javascript:void(0);"><?php echo $deal_view->title?></a></TD>
  <TD align="center"><?php echo $deal_view->total_money?> （元）</TD>
<TD  align="center">
<?php
//合同状态及相应的提示信息
echo '<b class="red">';
if($deal_view->u_ok==1&&$deal_view->u_ok_2==0){echo "我还未确认";}
elseif($deal_view->u_ok==1&&$deal_view->u_ok_2==2){echo "我不同意！";}
elseif($dealok){echo "合同已生效";}else{echo "雇主未确认";}
echo '</b>';

echo '<br>起草:'.dateYMD($deal_view->addtime);
if($dealok){
echo '<br>生效:'.dateYMD($deal_view->oktime);}
?>
</TD>

<TD align="center"><?php //=$deal_view->units?></TD>
<TD align="center"><?php //=$deal_view->r_price?></TD>
</tr>
<?php }else{?>
<tr class="edit_item_tr">
  <TD height="60" colspan="9"  align="center"><a href="javascript:void(0);">合同起草</a></TD></tr>
<?php }?>

</table>


</td></tr>
<?php }else{?>
<tr><td height="50" align="center">暂无信息</td></tr>
<?php }?>
</table>
<div class="clear"></div>
</div></div></div>
</div><div class="clear"></div>
</div></div>

<?php $this->load->view('public/footer');?>