<?php $this->load->view('public/validform'); ?>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><form class="validform" method="post"><table width="685" border="0" cellpadding="0" cellspacing="3"><tr><td width="100" align="right">提交给：</td><td align="left"><?php echo $this->User_Model->links($to_uid)?><input type="hidden" name="to_uid" id="to_uid" value="<?php echo $to_uid?>" /></td><td width="150" align="left">&nbsp;</td></tr> <tr>
  <td width="100" align="right">订单编号：</td><td width="220" align="left"><?php echo $order_no?><input type="hidden" name="order_no" id="order_no" value="<?php echo $order_no?>" /></td><td align="left">&nbsp;</td></tr> 

<?php
#显示相关的任务信息
if(!empty($rid)){?><tr><td align="right">相应任务：</td><td align="left"><?php echo $rid?><input type="hidden" name="rid"  id="rid" value="<?php echo $rid?>" /></td><td align="left">&nbsp;</td></tr><?php }?>

<tr>
  <td align="right"><span class="cost_title">费用</span>：</td><td align="left"><input name="cost" type="text" class="inputxt" id="cost" style="width:75%;" maxlength="7" nullmsg="费用不能为空！" errormsg="请填写一个1~7位的整数" datatype="n1-10" />&nbsp;&nbsp;&nbsp;<span class="tip" title="单位:元">元</span></td><td align="left"><div class="validform_checktip">请填写费用</div></td></tr>
<tr>
  <td align="right"><span class="cost_title">地址</span>：</td>
  <td align="left"><input class="inputxt" style="width:75%;" name="place" type="text" id="place" size="50" maxlength="40" nullmsg="地址不能为空！" errormsg="地址至少5个字符,最多40个字符" datatype="*5-70" /></td>
  <td align="left"><div class="validform_checktip">地址至少5个字符,最多40个字符</div></td></tr>
<tr><td align="right" valign="top"><span class="note_title">订单描述</span>：</td><td align="left" valign="top"><textarea name="note" cols="80" rows="5" class="inputxt" style="width:400px;" id="note" nullmsg="请填写订单描述！" errormsg="至少5个字符,最多70个字符" datatype="*5-70" ></textarea>
  </td><td align="left" valign="top"><div class="validform_checktip">请填写订单描述!</div></td></tr>
<tr>
  <td align="right">&nbsp;</td>
  <td align="left" class="edit_box_save_but" style="float:left;">
  <input type="submit" class="save_but" value="" /></td>
  <td>&nbsp;</td></tr></table></form>
</td></tr></table><div class="clear"></div></div></div></div>