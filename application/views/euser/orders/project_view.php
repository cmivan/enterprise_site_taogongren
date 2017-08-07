<?php $this->load->view('public/header'); ?>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'op');?>

<script language="javascript" type="text/javascript">
$(function(){   
    <?php /*?>订单操作-确认付款<?php */?>
	$(".edit_box #agree").click(function(){ if(confirm('确认同意以上的项目报价吗？')){ window.location.href='<?php echo reUrl("action=agree_price")?>'; }});
	<?php /*?>订单操作-不同意报价并回复意见<?php */?>
	$(".edit_box #notagree").click(function(){ var id=$(this).parent().attr("id");
		tb_show('提交不同意报价的原因','<?php echo site_url($c_urls.'/price_not_ok_msg')?>?height=95&width=300&id='+id,false);});
	<?php /*?>点击确认合同<?php */?>
	A_btu('deal_ok','温馨提示：确认后需要对方查看并确认合同才能生效？');
	<?php /*?>点击删除合同<?php */?>
	A_btu('deal_del','确定删除该合同吗？');
	<?php /*?>点击是否要开始<?php */?>
	A_btu('step_start','开始后，系统将自动从你的账户扣除该阶段的费用和5%的服务费到平台，确定开始该阶段吗？');
	<?php /*?>点击是否要验收<?php */?>
	A_btu('step_yanshou','验收后，系统将自动将相应的阶段费用支付到工人账户上，确定验收该阶段吗？');

 });
function A_btu(key,str){$("a."+key).click(function(){if(confirm(str)){$(this).attr("href",$(this).attr("link"));return true;}else{return false;} });}
</script>
</head><body>
<?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>
<div class="my_right"><div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div>
<div class="mainbox_box">
<?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php if(!empty($view)){?>
<tr><td height="60" align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0"><tr><td align="left"><?php echo $user_links?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-decoration:underline">单号：<?php echo $view->orderid?></span></td><td width="150" align="left">下单时间：<?php echo dateYMD($addtime)?></td><td width="40" align="center"><?php echo $order_stat_btu?></td><td width="72" align="center" class="diy_link_but"><a href="<?php echo site_url($c_urls)?><?php echo reUrl("")?>">返回</a></td></tr></table>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td align="left">&nbsp;一、订单基本要求</td></tr><tr class="edit_item_tr"><td align="left" style="padding:10px;"><?php echo $note?></td></tr></table>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td width="140" colspan="9" align="left"> &nbsp;二、工程报价单</td></tr>  
        
<?php if(!empty($price_view)){?>
  <tr>
  <td width="65" align="middle">编号</td>
  <td align="middle">项目</td>
  <td width="45" align="center">数量</td>
  <td width="45" align="center">单位</td>
  <td width="80" align="center">人工单价(元)</td>
  <td width="80" align="center">材料单价(元)</td>
  <td width="50" align="center">合计(元)</td>
  <td width="50" align="center">状态</td></tr>
<?php foreach($price_view as $pvrs){?>
  <tr class="edit_item_tr">
  <td align="middle"><?php echo $pvrs->id?></td>
  <td align="middle"><?php echo $pvrs->project?></td>
  <td align="center"><?php echo $pvrs->num?></td>
  <td align="center"><?php echo $pvrs->units?></td>
  <td width="80" align="center"><?php echo $pvrs->r_price?></td>
  <td width="80" align="center"><?php echo $pvrs->c_price?></td>
  <td width="50" align="center"><?php echo ($pvrs->r_price+$pvrs->c_price)*$pvrs->num?></td>
  <td width="50" align="center"><?php echo $this->Orders_Model->prostat($pvrs->u_ok);?></td></tr>
<?php }?>

<tr items="proitem_<?php echo $id?>"><td colspan="9" class="gysm">
共个 <span class="chenghong2"><?php echo $price_num?></span> 项目 , 
所有项目报价合计 <span class="chenghong"><?php echo $allprice?></span>元 ,
有效项目报价合计 <span class="chenghong"><?php echo $allprice1?></span>元。
</td></tr>

<?php if($ostat==false&&$new_quote!=1){?>
<tr><td colspan="8" align="left">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td id="<?php echo $id?>">
<?php if($new_quote!=2){?>
<input name="notagree" type="button" class="myinputbut" id="notagree" value=" 我不同意 " /><?php }else{?>
<input type="button" class="myinputbut" value=" 我已不同意报价 " disabled="disabled" /><?php }?>
<input name="agree" type="button" class="myinputbut" id="agree" value=" 我同意以上的报价 " />
<?php if($new_quote==2){echo "&nbsp;<span class=red>不同意以上报价的原因：".$view->feed."</span>";}?></td></tr></table></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td height="60" colspan="9"  align="center">等待报价...</td></tr><?php }?></table>

<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist"><td colspan="5" align="left"> &nbsp;三、 合同信息</td></tr> 
<?php if(!empty($deal_view)){?>
<tr>
  <td align="middle">项目名称</td>
  <td width="85" align="middle">交易金额(元)</td>
  <td align="center">合同状态</td>
  <td width="110" align="center">当前可操作</td>
  <td width="68" align="center">流程指引</td></tr><tr class="edit_item_tr">
  <td height="80" align="middle">
  <a class="tip" title="点击可以查看合同详细内容!" target="_blank" href="<?php echo site_url($c_urls.'/deal/'.$id)?>" style="text-decoration:underline"><?php echo $deal_view->title?></a>
  </td>
<td align="center"><?php echo $deal_view->total_money?></td>
<td align="center">
<?php
//合同状态及相应的提示信息
echo order_deal_stat_show_yz($deal_view->u_ok,$deal_view->u_ok_2,$deal_view->feed,$dealok,$deal_view->addtime,$deal_view->oktime);
?>
</td>

<td align="center" class="diy_link_but">
<?php if($deal_view->u_ok==0){?>
<a href="javascript:void(0);" link="<?php echo reUrl("action=ok&id=".$id)?>" class="deal_ok">确认合同</a>
<?php }else{?><div class="text">我已确认</div><?php }?>
<?php if($dealok==false){?><div class="clear"></div><a href="<?php echo site_url($c_urls.'/deal_edit/'.$id)?>" target="_blank" >编辑合同</a><?php }?>
</td>

<td align="center" class="diy_link_but">

<a href="<?php echo site_url($c_urls.'/deal/'.$id)?>">查看合同</a>
<?php if($deal_view->u_ok<>1&&$deal_view->u_ok_2<>1){?>
<div class="clear"></div>
<a href="javascript:void(0);" link="<?php echo reUrl("action=del&id=".$row["id"])?>" class="deal_del">删除合同</a><?php }?>
</td></tr>

<?php
if($dealok){ $OPSnum=0;
foreach($deal_steps as $dsrs){
	$OPSnum++;
?>
<tr class="edit_item_tr"><td align="center">工程第 <b class="chenghong big" style="font-size:24px; font-family:Arial, Helvetica, sans-serif"><?php echo $dsrs->stepNO?></b>  阶段</td><td align="center">
<?php
  //合同阶段费用
  echo $dsrs->money;
  //在相应的步骤显示诚意金
  echo order_deal_cy_money($deal_view->cy_money,$deal_view->cy_money);
?>
</td><td align="center">
<?php
 /*显示合同步骤状态*/
echo order_deal_step_stat($dsrs->startdate,$dsrs->paydate);?>
</td><td align="center" class="diy_link_but">
<?php $step_stat = $this->Orders_Model->project_step_stat($logid,$dsrs->o_id,$dsrs->stepNO,1);?>
<?php
 /*显示合同步骤状态2*/
echo order_deal_step_stat_2($step_stat,$dsrs->stepNO,$dsrs->ispay);?>
</td><td align="center" class="diy_link_but">
<?php
 /*显示合同步骤操作按钮*/
echo order_deal_step_btu($step_stat,$dsrs->stepNO,$dsrs->ispay);?>
</td></tr>
<?php }}}else{?>

<?php if($new_quote!=1){?>
<tr class="edit_item_tr"><td height="60" colspan="5"  align="center"><a href="javascript:void(0);">+合同起草+</a></td></tr>
<?php }else{?>
<tr class="edit_item_tr"><td height="60" colspan="5"  align="center">
<a href="<?php echo site_url($c_urls."/deal_edit/".$id)?>" target="_blank">+合同起草+</a>
</td></tr>
<?php }}?>
</table>

<?php
//<><><> 返回结算费用
if($ostat&&!empty($deal_view)){
	//$addcost = 0; //成已经
	$allcost  = get_num($allprice);    //有效报价
	$dealcost = get_num($deal_view->total_money);  //合同金额报价
	$CYcost   = get_num($deal_view->cy_money,0);     //合同诚意金
	if($allcost&&$dealcost&&$CYcost){
	  if($allcost>=$dealcost+$CYcost){
		 #需要使用全部诚意金
		 $addcost = $CYcost;
	  }elseif(($allcost>$dealcost)&&($allcost<$dealcost+$CYcost)){
		 #需要使用部分诚意金
		 $addcost = $allcost-$dealcost;
	  }
	}
if($dealcost){
?>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td colspan="3" align="left"> &nbsp;四、 结算清单</td></tr> 
<?php if(!empty($deal_view)){?>   <tr><td align="middle">合同金额（元）</td><td width="120" align="center">诚意金(元)</td><td width="200" align="center">有效的工程报价</td></tr><tr class="edit_item_tr"><td align="middle"><?php echo $dealcost?></td><td align="center"><?php echo $CYcost?></td><td align="center"><?php echo $allcost?></td></tr><?php }?>
</table>
<?php }}else{ echo "订单进行中...";}?>
</td></tr><?php }else{?><tr>
<td height="50" align="center">暂无相关信息</td></tr><?php }?></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>