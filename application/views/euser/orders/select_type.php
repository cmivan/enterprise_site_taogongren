<?php $this->load->view('public/header'); ?>
<style>
#order_select_box td a{float:left;width:auto;padding-top:10px;padding-bottom:10px;line-height:35px;background-color:#FFF;font-size:12px;text-decoration:none;color:#666;border:#FFEACA 1px solid;}
#order_select_box td a span{font-family:"黑体";font-size:24px;color:#333;}
#order_select_box td a:hover span{font-size:24px;text-decoration:none;color:#F60;}
#order_select_box td a:hover{background-color:#FFFFF0;color:#000;border-bottom:#CDB38B 1px solid;border-right:#CDB38B 1px solid;}
#order_select_box td b{line-height:170%;text-align:left;float:left;padding-left:7px;font-weight:lighter;}
#order_select_box td b span{font-family:"宋体";font-size:12px;font-weight:lighter;line-height:150%;color:#F00;float:left;padding-top:7px;}
#order_select_box td a:hover b{font-size:14px;}</style></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_url); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="2" cellspacing="6">           
<tr><td height="20" colspan="3" valign="top">
<div class="tipbox tipbox_edit" style="position:relative;">
<a style="position:absolute; right:20px; top:5px; font-size:12px; font-weight:lighter" href="?back">返回上一级</a>
第二步：请选择要下哪种订单给工人 <?php echo $this->User_Model->links($to_uid)?>
<br><span>( 温馨提示：请坚持线上交易，保障安全! )</span>
</div>
</td></tr>     
<tr id="order_select_box">
<td width="33%" height="200" align="center" valign="top"><a href="<?php echo site_url($c_url.'orders_door/add/'.$to_uid)?>"><span>上门单</span><br /><b>邀请工人上门实地测量、查看，有助于工人准确了解工程，给出合理报价。<br /><span style="font-size:12px;">您可以优先选择下单给那些在特定区域免上门费的工人。</span></b></a></td><td width="33%" align="center" valign="top"><a href="<?php echo site_url($c_url.'orders_simple/add/'.$to_uid)?>"><span>简化单</span><br /><b style="text-align:left">简洁的订单流程，简短的需求描述，方便快速下单，系统自动下发短信通知，工人直接上门开工作业。<br /><span style="font-size:12px;">请确保在下单前，与工人取得联系，双方沟通好工程的作业内容、所需费用等。</span></b></a>
  </td>
  <td width="33%" align="center" valign="top"><a href="<?php echo site_url($c_url.'orders_project/add/'.$to_uid)?>"><span>工程单</span><br /><b>完善的订单流程，工人提供详细报价单，在线合同约定工程的作业步骤、要求，第三方划款、退款流程充分保障您的利益。</b></a></td>
 </tr></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>