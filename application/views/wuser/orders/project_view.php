<?php $this->load->view('public/header'); ?>

<?php /*?>加载评分所需的JS<?php */?>
<?php echo $this->Common_Model->evaluate_js($c_url,'op');?>

<script language="javascript" type="text/javascript">
$(function(){
	<?php /*?>删除报价<?php */?>
	$("a.delpro").click(function(){
	   var thisid=$(this).parent().attr("id");
	   if(confirm('确认要删除该项报价吗？')){
		  $(this).attr("href","<?php echo reUrl("action=price_del&pid=")?>"+thisid);
		  return true;
	   }else{
		  return false;
	   }
	});
	<?php /*?>修改报价<?php */?>
	$("a.editpro").click(function(){
	   var pro_id=$(this).parent().attr("pro_id");
	   var edit_id=$(this).parent().attr("id");
	   $(this).attr("href","<?php echo site_url($c_urls.'/add_price/'.$id)?>?edit_id="+edit_id);
	   return true;
	});
	<?php /*?>点击确认合同<?php */?>
	$("a.deal_ok").click(function(){
		<?php /*?>温馨提示：对方是否对此合同内容满意，点击确认后双方都无法更改合同内容，是否再继续？<?php */?>
		if(confirm('温馨提示：\r\n你确定已经满意此合同\r\n点击确认后双方都无法更改合同内容\r\n是否继续？')){
		   $(this).attr("href",$(this).attr("link"));
		   return true;
		}else{
		   return false;
	    }
	});
	<?php /*?>点击不同意合同<?php */?>
	$("a.deal_notok").click(function(){
		var orderid = $(this).attr("id");
		tb_show('请在下面填写不同意合同原因：','<?php echo site_url($c_urls.'/deal_not_ok_msg')?>?height=95&width=300&id='+orderid,false);
		});
 });
 </script>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>
<div class="my_right"><div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div>
<div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?><div class="content"><br><table width="100%" border="0" cellpadding="0" cellspacing="0">

<?php if(!empty($view)){?>
<tr><td height="60" align="center">

<table width="100%" border="0" cellpadding="3" cellspacing="0"><tr><td align="left"><?php echo $user_links?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-decoration:underline">单号：<?php echo $view->orderid?></span></td><td width="180" align="left">下单时间：<?php echo dateHi($addtime)?></td><td width="50" align="center"><?php echo $order_stat_btu?></td></tr></table>

<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist"><td align="left">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;一、订单基本要求</td>
<td width="98" align="center" class="diy_link_but"><a href="<?php echo site_url($c_urls)?><?php echo reUrl("")?>">返回</a></td></tr></table>
</td><!--<td width="60" align="center">费用(元)</td>--></tr><tr class="edit_item_tr"><td align="left" style="padding:10px;"><?php echo $note?></td><!--<td align="center"><?php echo $allprice?></td>--></tr></table>


<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;">
<tr class="edit_item_frist"><td colspan="9" align="left">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;二、工程报价单</td>
<td width="98" align="center" class="diy_link_but">
<?php
/*订单为完成的情况下，可以继续添加报价*/
if($ostat==false)
{
	echo '<a href="'.site_url($c_urls.'/add_price/'.$id).'" id="add_pro_price">添加报价项目</a>';
}else{
	echo '&nbsp;';
}
?>
</td></tr></table>

</td></tr> 
         
<?php
/*如果报价项目不为空则显示内容*/
if(!empty($price_view)){?>
    <tr>
    <td width="65" align="middle">编号</td>
    <td align="middle">项目</td>
    <td width="45" align="center">数量</td>
    <td width="45" align="center">单位</td>
    <td width="80" align="center">人工单价(元)</td>
    <td width="80" align="center">材料单价(元)</td>
    <td width="50" align="center">合计(元)</td>
    <td width="50" align="center">状态</td>
    <?php if($new_quote!=1){?><td width="75" align="center">操作</td><?php }?>
    </tr>

  <?php
  /*列出报价项目*/
  foreach($price_view as $pvrs){?>
    <tr class="edit_item_tr">
    <td align="middle"><?php echo $pvrs->id?></td>
    <td align="middle"><?php echo $pvrs->project?></td>
    <td align="center"><?php echo $pvrs->num?></td>
    <td align="center"><?php echo $pvrs->units?></td>
    <td width="80" align="center"><?php echo $pvrs->r_price?></td>
    <td width="80" align="center"><?php echo $pvrs->c_price?></td>
    <td width="50" align="center"><?php echo ($pvrs->r_price+$pvrs->c_price)*$pvrs->num?></td>
    <td width="50" align="center"><?php echo $this->Orders_Model->prostat($pvrs->u_ok);?></td>
    <?php
    /*显示项目报价的状态(是不该报价已经通过)*/
    if($new_quote!=1){?>
       <td align="center" id="<?php echo $pvrs->id?>" pro_id="<?php echo $pvrs->id?>"><?php echo $this->Orders_Model->prostat($pvrs->u_ok,1);?></td>
    <?php }?>
    </tr>
  <?php }?>

    <tr items="proitem_<?php echo $id?>"><td colspan="9" class="gysm">
    共个 <span class="chenghong2"><?php echo $price_num?></span> 项目 , 
    所有项目报价合计 <span class="chenghong"><?php echo $allprice?></span>元 ,
    有效项目报价合计 <span class="chenghong"><?php echo $allprice1?></span>元。
    </td></tr>

  <?php
  /*在订单未完成的情况下*/
  if($ostat==false){?>
    <tr><td colspan="9" align="left">
    <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td class="diy_link_but">
    <?php /*返回业主对报价信息的确认状态（用于工人页面显示）*/
       $user_links = $this->User_Model->links($view->uid);
       echo order_project_price_stat($user_links,$new_quote,$view->feed);
    ?>
    </td></tr></table></td></tr>
  <?php }?>

<?php }else{?>
    <tr class="edit_item_tr"><td height="60" colspan="9"  align="center">
    <a href="<?php echo site_url($c_urls.'/add_price/'.$id)?>" id="add_pro_price">+ 添加报价项目 +</a>
    </td></tr>
<?php }?>

</table>



<?php
/*当报价项目有不同意的*/
if($new_quote==1){?>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist">
<td colspan="4" align="left"> &nbsp;三、 合同信息</td></tr> 
<?php if(!empty($deal_view)){?>
  <tr>
  <td align="middle">项目名称</td>
  <td width="85" align="middle">交易金额(元)</td>
  <td align="center">合同状态</td>
  <td width="110" align="center">当前可操作</td></tr><tr class="edit_item_tr">
  <td align="middle">
  <a class="tip" title="点击可以查看合同详细内容!" href="<?php echo site_url($c_urls.'/deal/'.$id)?>" style="text-decoration:underline"><?php echo $deal_view->title?></a>
  </td>
<td align="center"><?php echo $deal_view->total_money?></td><td align="center">
<?php
//合同状态及相应的提示信息
echo order_deal_stat_show_gr($deal_view->u_ok,$deal_view->u_ok_2,$deal_view->feed,$dealok,$deal_view->addtime,$deal_view->oktime);
?>
</td>
<td align="center" class="diy_link_but">

<a href="<?php echo site_url($c_urls.'/deal/'.$id)?>">查看合同</a>
<?php if($deal_view->u_ok==1&&$deal_view->u_ok_2==0){?>
<div class="clear"></div>
<a href="javascript:void(0);" class="deal_ok" link="<?php echo reUrl("action=deal_ok")?>">同意合同</a>
<a href="javascript:void(0);" class="deal_notok" id="<?php echo $id?>">不同意</a>
<?php }?>

</td></tr>
<?php
if($dealok){ $OPSnum=0;
foreach($deal_steps as $dsrs){
	$OPSnum++;
?><tr class="edit_item_tr"><td align="center">工程第 <b class="chenghong big" style="font-size:24px; font-family:Arial, Helvetica, sans-serif"><?php echo $dsrs->stepNO?></b>  阶段</td><td align="center">
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
</td></tr>
<?php }}?>
<?php }else{?><tr class="edit_item_tr"><td height="60" colspan="4"  align="center"><a href="javascript:void(0);">合同起草</a></td></tr><?php }?>
</table>
<?php }?>




<?php
//<><><> 返回结算费用
if($ostat&&!empty($deal_view)){
   $allcost  = get_num($allprice);    //有效报价
   $dealcost = get_num($deal_view->total_money);  //合同金额报价
   $CYcost   = get_num($deal_view->cy_money,0);     //合同诚意金
   if($allcost&&$dealcost&&$CYcost){
	  if($allcost>=$dealcost+$CYcost){
		 #需要使用全部诚意金
		 $addcost=$CYcost;
	  }elseif(($allcost>$dealcost)&&($allcost<$dealcost+$CYcost)){
		 #需要使用部分诚意金
		 $addcost=$allcost-$dealcost;
	  }
   }
   
if($dealcost){
?>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td colspan="3" align="left"> &nbsp;四、 结算</td></tr> 
<?php if(!empty($deal_view)){?>   <tr><td align="middle">合同金额（元）</td><td width="120" align="center">诚意金(元)</td><td width="200" align="center">有效的工程报价</td></tr><tr class="edit_item_tr"><td align="middle"><?php echo $dealcost?></td><td align="center"><?php echo $CYcost?></td><td align="center"><?php echo $allcost?></td></tr><?php }?>
</table>
<?php }}else{ echo "订单进行中...";} ?>
</td></tr><?php }else{?><tr><td height="50" align="center">暂无信息</td></tr><?php }?></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>