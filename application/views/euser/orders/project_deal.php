<?php $this->load->view('public/header'); ?>
<script type="text/javascript">
$(function(){	
  reStep();
  <?php /*?>显示按钮<?php */?>
  $("#add_step").click(function(){
	  var stepnum=$(".pro_step").find(".item").size();
	  stepnum=parseInt(stepnum);
	  var newStepTmp=$("#pro_step_temp").html();
	  $(".pro_step").append(newStepTmp); reStep(); });
  <?php /*?>删除步骤<?php */?>
  $(".del_step").live("click",function(){
	  var stepID=parseInt($(".del_step").index(this))+1;
	  if(confirm('确定取消【工程第'+stepID+'阶段】?')){
	  var stepnum=$(".pro_step").find(".item").size();
	  if(stepnum>1){ $(this).parent().parent().parent().parent().parent().parent().remove(); reStep(); }
	  else{ alert("至少要有一个阶段！"); }}});
  <?php /*?>是否同意协议<?php */?>
  $("#xyok").click(function(){
	  var xyok=$(this).attr("checked");
	  if(xyok){ $("#fabu").attr("disabled",false); }else{ $("#fabu").attr("disabled",true); }
  });
});<?php /*?>重写步骤数<?php */?>
function reStep(){
  var reNum=0;
  $(".pro_step").find(".item").each(function(){reNum++;$(this).find("b").text(reNum);});
  $(".pro_step").find(".item").find('.del').css({'display':'block'});
  if(reNum==1){$(".pro_step").find(".item").eq(0).find('.del').css({'display':'none'});}
}</script><style type="text/css">
form{margin:0;}
.pro_main_title{font-size:14px;font-weight:bold;color:#333;}.pro_deal_look td{color:#333;}
#pro_step .item{background-color:#FFFAF0;border:#FFDEAD 1px solid;padding:10px;margin-bottom:10px;}	
#pro_step .item .del{float:right;text-align:center;padding-right:4px;}</style></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="edit_box"><tr><td align="left"><form class="validform" method="post"><table width="96%" border="0" align="center" cellpadding="2" cellspacing="5">
<?php /*?><tr><td width="601" height="60" align="left" valign="top"><h1>合同<?php echo $editstr?></h1></td></tr> <?php */?>
<tr><td height="10" align="left"></td></tr><tr><td height="35" align="left">项目名称：&nbsp;<input name="title" type="text" id="title" value="<?php echo $title?>" style="width:350px;" /></td></tr><tr><td align="left">
甲方：<?php echo $this->User_Model->links($uid)?>（淘工人号）：<?php echo $uid?>　　乙方：<?php echo $this->User_Model->links($uid_2)?>（淘工人号）：<?php echo $uid_2?></td></tr>
<tr>
  <td align="left">   <span class="pro_main_title" style="font-size:12px;">总金额</span>&nbsp;
    <input name="total_money" type="text" value="<?php echo $total_money?>" size="8" />
    &nbsp;人民币（元）， <span class="pro_main_title" style="font-size:12px;">诚意金 </span>
    <input name="cy_money" type="text" id="cy_money" value="<?php echo $cy_money?>" size="8" style="text-align:center" />&nbsp;人民币（元）<br />
    注：诚意押金由双方协商,在合同生效后甲方(雇主 ) 预付到淘工人平台上</td></tr>
    <tr>
  <td align="left"><span class="pro_main_title"> 一：项目概况</span></td></tr><tr>
  <td align="left">每一阶段完成后款项的90%将自动划入工人帐号下，其中5%作为质保押金暂存平台，5%作为服务费。</td></tr><tr><td align="left">项目要求：</td></tr><tr><td align="left"><textarea name="yaoqiu" rows="8" id="yaoqiu" style="width:99%;"><?php echo $yaoqiu_note?></textarea></td></tr>
<tr>
  <td align="left"><span class="pro_main_title">二：工程收费标准与服务步骤</span></td></tr>
  <tr><td align="left" id="pro_step">
<div class="pro_step"><?php for($i=0;$i<$countItem;$i++){?><div class="item"><table width="100%" border="0" cellpadding="0" cellspacing="5"><tr><td><span class="pro_main_title">工程第<b><?php echo $i+1?></b>阶段：</span></td><td><div class="del"><a href="javascript:void(0);" class="del_step"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /> 删除</a></div></td></tr><tr><td colspan="2"> 客户方需预付金额&nbsp;<input type="text" name="money[]" size="8" value="<?php echo $money[$i]?>" />
&nbsp;人民币（元）  到淘工人平台 ，  该步需要&nbsp;<input type="text" name="days[]" size="8" value="<?php echo $days[$i]?>" />
&nbsp;天完成。 </td></tr><tr><td colspan="2"> 具体工作内容： </td></tr><tr><td colspan="2"><textarea name="content[]" rows="6" id="content[]" style="width:99%;"><?php echo $content[$i]?></textarea></td></tr></table></div><?php }?>

<?php if($countItem==0){?><div class="item"><table width="100%" border="0" cellpadding="0" cellspacing="5"><tr><td><span class="pro_main_title">工程第<b>1</b>阶段：</span></td><td><div class="del"><a href="javascript:void(0);" class="del_step"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /> 删除</a></div></td></tr><tr><td colspan="2"> 客户方需预付金额&nbsp;<input type="text" name="money[]" size="8" />
&nbsp;人民币（元）  到淘工人平台 ，  该步需要&nbsp;<input type="text" value="" name="days[]" size="8" />
&nbsp;天完成。 </td></tr><tr><td colspan="2"> 具体工作内容： </td></tr><tr><td colspan="2"><textarea name="content[]" rows="6" id="content[]" style="width:99%;"><?php echo $content?></textarea></td></tr></table></div><?php }?>
</div><div><a href="javascript:void(0);" id="add_step"><img src="<?php echo $img_url?>my/ico/add_small.gif" width="16" height="16" align="left" />添加新的工程阶段</a></div></td></tr>
  <tr><td align="left"><span class="pro_main_title">三：其他准则</span> (双方协商的准则，选填)</td></tr><tr><td align="left"><textarea name="other" rows="5" id="other" style="width:99%;"><?php echo $other?></textarea></td></tr><tr><td align="left"><span class="pro_main_title">四：合同事宜</span></td></tr><tr>
<td align="left">
1、双方在执行本合同过程中，如发生不能通过双方协调解决事宜，双方都自愿接受淘工人官方的仲裁，并且双方承诺履行淘工人的仲裁结果。&nbsp;<br />
2、本合同在双方确定同意，则开始生效。&nbsp;<br />
3、双方声明遵守并自愿履行淘工人平台的<a href="<?php echo site_url('page/agreement')?>" target="_blank" style="color:#03C; text-decoration:underline;">交易规则</a></td></tr>
<tr><td valign="top">
 <div class="tipbox"><input name="xyok" type="checkbox" id="xyok" value="yes" <?php if($xyok=="yes"){echo ' checked="checked"';}?> />
 是否同意：成功下单后，先把预计的工程任务款打到淘工人网站，同时收取 <span class="chenghong">5</span> 元服务费。<br />
 </div></td></tr>
<tr><td align="center"><div class="cm_btu"><input class='buttom' type="button" name="back" id="back" value="   返回   "
 onClick="window.location.href='<?php echo site_url($c_urls.'/view/'.$id).reUrl('')?>';"/><input class='buttom' type="submit" name="fabu" id="fabu" value="  生成合同  " <?php if($xyok!="yes"){echo ' disabled=disabled';}?>/></div><input type="hidden" name="r_ouid" id="r_ouid" value="<?php echo $uid?>" /><input type="hidden" name="r_rid"  id="r_rid" value="<?php echo $retrieval_id?>" /><input type="hidden" name="edit_id" id="edit_id" value="<?php echo $id?>" /></td></tr>
<?php //if(!empty($backtip)){?><tr><td align="left"><span class="red"><?php //=$backtip?></span></td></tr><?php //}?>
</table></form></td></tr></table>
<div id="pro_step"><div id="pro_step_temp" style="display:none;"><div class="item"><table width="100%" border="0" cellpadding="0" cellspacing="5"><tr><td><span class="pro_main_title">工程第<b>{num}</b>阶段：</span></td><td><div class="del"><a href="javascript:void(0);" class="del_step"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /> 删除</a></div></td></tr><tr><td colspan="2"> 客户方需预付金额&nbsp;<input type="text" name="money[]" size="8" />
&nbsp;人民币（元）  到淘工人平台 ，  该步需要&nbsp;<input type="text" value="" name="days[]" size="8" />
&nbsp;天完成。 </td></tr><tr><td colspan="2"> 具体工作内容： </td></tr><tr><td colspan="2"><textarea name="content[]" rows="6" id="content[]" style="width:99%;"></textarea></td></tr></table></div></div></div>

<div class="clear"></div></div>
</div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>