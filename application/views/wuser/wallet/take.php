<?php $this->load->view('public/validform'); ?>
<?php /*?>倒计时<?php */?>
<script language="javascript" src="<?php echo $js_url;?>sms_timeout.js"></script>
<script language="javascript" src="<?php echo site_url('global_v1/sms_js/tx')?>"></script>

<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> <div class="info">
&nbsp;&nbsp; 淘工币：<label class="chenghong"><?php echo $cost_T?></label> 个
&nbsp;&nbsp; 现金账户：<label class="chenghong"><?php echo $cost_S?></label> 元</div></div>
<div class="mainbox_box"><div class="content"><br><form class="validform" method="post"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3" style="font-size:14px; padding:6px; padding-left:28px;" class="tipbox">以下均为必填项-为成功，请确保您的信息无误</td></tr><tr><td height="20" colspan="3"></td></tr><tr>
<td align="right">收款人姓名：</td>
<td width="200"><input name="username" type="text" id="username" class="inputxt" maxlength="10" nullmsg="收款人姓名不能为空!" errormsg="收款人姓名至少2个字符,最多6个字符" datatype="*2-6"/>
</td>
<td><div class="validform_checktip">
<div class="validform_checktip">至少2个字符,最多6个字符</div>
</div></td></tr>
<tr><td align="right">收款人银行帐号：</td>
<td><input name="cardnum" type="text" id="cardnum" class="inputxt" maxlength="20" nullmsg="收款人银行帐号不能为空!" errormsg="至少1个字符,最多30个字符" datatype="*1-30"  />
</td>
<td><div class="validform_checktip"></div>
</td></tr><tr>
<td align="right">开户银行：</td>
<td><input name="cardat" type="text" class="inputxt" id="cardat" maxlength="20" nullmsg="开户银行不能为空!" errormsg="开户银行不能为空!" datatype="*"/></td><td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">银行所在地：</td><td>
<?php
$ps = $this->Place_Model->provinces();
$cs = $this->Place_Model->citys($u_place->p_id);
$as = $this->Place_Model->areas($u_place->c_id);
?><select name="p_id" id="p_id" datatype="select" errormsg="请选择省份!" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($u_place->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市!" disabled style="width:74px;">
<?php if(!empty($cs)){?>
<?php foreach ($cs as $rs){?>
<option value="<?php echo $rs->c_id?>" <?php if($u_place->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> >
<?php echo $rs->c_name?>
</option>
<?php }}else{?>
<option value="">请选择...</option>
<?php }?></select></td><td><div class="validform_checktip"></div></td></tr><tr>
<td align="right">金额：</td>
<td><input name="cost" type="text" class="inputxt" id="cost" style="width:178px;" maxlength="5" nullmsg="金额不能为空!" errormsg="金额应为正整数!" datatype="*" />&nbsp;&nbsp;元</td>
<td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">验证码：</td>
<td><input name="yzm" type="text" class="inputxt" id="yzm" maxlength="4" nullmsg="金额不能为空!" errormsg="金额应为正整数!" datatype="p" /></td>
<td><label id="send_sms"><a href="javascript:void(0);" cmd='null'>获取验证码</a></label></td>
</tr>
<tr><td align="right">&nbsp;</td><td><span class="cm_btu"><input type="submit" class="buttom" id="submit_but" value="提交"></span><input name="mobile" type="hidden" id="mobile" value="11111111111"/></td>
<td>&nbsp;</td>
</tr></table></form><br><br><br><br><br><br><br><br>
<div class="clear"></div></div>
</div></div>