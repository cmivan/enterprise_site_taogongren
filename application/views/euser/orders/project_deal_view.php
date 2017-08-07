<?php $this->load->view('public/header'); ?>
<style type="text/css">
form{margin:0;}
.pro_main_title{font-size:14px;font-weight:bold;color:#333;}.pro_deal_look td{color:#333;}
#pro_step .item{background-color:#FFFAF0;border:#FFDEAD 1px solid;padding:10px;margin-bottom:10px;}	
#pro_step .item .del{float:right;text-align:center;padding-right:4px;}</style></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1" class="edit_box"><tr><td align="left">
<table width="96%" border="0" align="center" cellpadding="2" cellspacing="5" class="pro_deal_look">


          <tr>
            <td colspan="2" align="left">项目名称：<?php echo $title?></td>
            </tr>
<tr><td align="left">
甲方：<?php echo $this->User_Model->links($uid)?>（淘工人号）：<?php echo $uid?>　　乙方：<?php echo $this->User_Model->links($uid_2)?>（淘工人号）：<?php echo $uid_2?></td></tr>

<tr>
  <td colspan="2" align="left">
   <span class="pro_main_title" style="font-size:12px;">总金额</span>&nbsp;
    <?php echo $total_money?>
    &nbsp;人民币（元）， 
  
    <span class="pro_main_title" style="font-size:12px;">诚意押金 </span>
    <?php echo $cy_money?>
&nbsp;人民币（元） &nbsp;(由双方协商,在合同生效后甲方[ 雇主 ] 预付到平台上)</td></tr>
    
<tr>
  <td colspan="2" align="left"><span class="pro_main_title"> 一：项目概况</span></td></tr>
<tr><td colspan="2" align="left">每一阶段款项的90%自动划入工人帐号下，5%做为质保押金暂存平台；扣取服务费5%</td></tr>
<tr><td colspan="2" align="left">项目要求：</td></tr>
<tr><td colspan="2" align="left"><?php echo $yaoqiu_note?></td></tr>

<tr>
  <td colspan="2" align="left"><span class="pro_main_title">二：工程收费标准与服务步骤</span></td></tr>
  
<tr><td colspan="2" align="left" id="pro_step">
<?php
for($i=0;$i<$countItem;$i++){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="32" valign="bottom"><span class="pro_main_title">工程第<b><?php echo $i+1?></b>阶段：</span></td>
    </tr>
  <tr>
    <td height="30"> 客户方需预付金额&nbsp;<?php echo $money[$i]?>
      &nbsp;人民币（元）  到淘工人平台 ，  该步需要&nbsp;<?php echo $days[$i]?>
      &nbsp;天完成。 </td>
    </tr>
  <tr>
    <td height="25"> 具体工作内容： </td>
    </tr>
  <tr>
    <td style="color:#666"><?php echo $content[$i]?></td>
  </tr>
</table>
<?php }?>

</td></tr>
  
<tr>
  <td colspan="2" align="left"><span class="pro_main_title">三：其他准则</span> (双方协商的准则，选填)</td></tr>
<tr>
  <td colspan="2" align="left"><?php echo $other?></td></tr>
<tr>
  <td colspan="2" align="left"><span class="pro_main_title">四：合同事宜</span></td></tr>
<tr>

  <td colspan="2" align="left"> 1、双方在执行本合同过程中，如发生不能通过双方协调解决事宜，双方都自愿接受淘工人官方的仲裁，并且双方承诺履行淘工人的仲裁结果。&nbsp;<br />
  2、本合同在双方确定同意，则开始生效。&nbsp;<br />
  3、双方声明遵守并自愿履行淘工人平台的<a href="page_agreement.php" target="_blank">交易规则</a></td></tr>
<tr><td align="center"><div class="cm_btu"><input class='buttom' type="button" name="back" id="back" value="返回订单"
 onClick="window.location.href='<?php echo site_url($c_urls.'/view/'.$id).reUrl('')?>';"/></div></td></tr>
</table>
</td></tr></table>
<div id="pro_step"><div id="pro_step_temp" style="display:none;"><div class="item"><table width="100%" border="0" cellpadding="0" cellspacing="5"><tr><td><span class="pro_main_title">工程第<b>{num}</b>阶段：</span></td><td><div class="del"><a href="javascript:void(0);" class="del_step"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /> 删除</a></div></td></tr><tr><td colspan="2"> 客户方需预付金额&nbsp;<input type="text" name="money[]" size="8" />
&nbsp;人民币（元）  到淘工人平台 ，  该步需要&nbsp;<input type="text" value="" name="days[]" size="8" />
&nbsp;天完成。 </td></tr><tr><td colspan="2"> 具体工作内容： </td></tr><tr><td colspan="2"><textarea name="content[]" rows="6" id="content[]" style="width:99%;"></textarea></td></tr></table></div></div></div>

<div class="clear"></div></div>
</div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>