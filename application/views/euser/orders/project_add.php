<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><form class="validform" method="post"><table width="685" border="0" cellpadding="0" cellspacing="3"><tr><td width="100" align="right">提交给：</td><td align="left"><?php echo $this->User_Model->links($to_uid)?><input type="hidden" name="to_uid" id="to_uid" value="<?php echo $to_uid?>" /></td><td width="150" align="left">&nbsp;</td></tr> <tr>
  <td width="100" align="right">订单编号：</td><td width="220" align="left"><?php echo $order_no?><input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no?>" /></td><td align="left">&nbsp;</td></tr> 
<?php
#显示相关的任务信息
if(!empty($rid)){?><tr><td align="right">相应任务：</td><td align="left"><?php echo $rid?><input type="hidden" name="rid"  id="rid" value="<?php echo $rid?>" /></td><td align="left">&nbsp;</td></tr><?php }?>
<tr><td align="right" valign="top"><span class="note_title">订单描述</span>：</td>
  <td align="left" valign="top">
  <textarea name="note" cols="80" rows="5" class="inputxt" style="width:400px;" id="note" nullmsg="请填写订单描述！" errormsg="至少5个字符,最多70个字符" datatype="*5-70" ></textarea>
    </td>
  <td align="left" valign="top"><div class="validform_checktip">请填写订单描述!</div></td></tr>
<tr>
  <td align="right">&nbsp;</td>
  <td align="left" class="edit_box_save_but" style="float:left;">
  <input type="submit" class="save_but" value="" /></td>
  <td>&nbsp;</td></tr></table></form>
</td></tr></table><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>