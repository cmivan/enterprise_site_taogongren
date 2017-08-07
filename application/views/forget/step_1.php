<?php $this->load->view('public/header'); ?>
<?php /*?>倒计时<?php */?>
<script language="javascript" src="<?php echo $js_url;?>sms_timeout.js"></script>
<script language="javascript" src="<?php echo site_url('global_v1/sms_js/forget')?>"></script>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="10"><tr><td valign="top" class="page_main_title"><div style="float:left;">找回密码！(第一步)</div><div style="float:right; background:none;">或者请 <a href="javascript:void(0);" class="user_login">登录</a></div></td></tr><tr><td valign="top"><div class="tipbox">
请输入您注册时填写的手机号码，我们将会把您验证码发到你的手机上 再进行下一步操作。</div></td></tr><tr><td height="245" valign="top" class="page_main_content"><br>
<div class="diy_form" style="padding-left:80px;"><form class="validform"><table border="0" cellpadding="0" cellspacing="3"><tr><td><div class="val_left"></div></td><td><div class="val_center"></div></td><td><div class="val_right"></div></td></tr><tr>
<td>手机：</td>
<td><input type="text" name="mobile" id="mobile" class="inputxt" datatype="m" nullmsg="请输入您帐号所绑定的手机号！" errormsg="请输入您的手机号码！" /></td>
<td><div class="validform_checktip">请输入您帐号所绑定的手机号！</div></td></tr>
<tr><td>验证码：</td><td colspan="2" class="td30"><table border="0" cellpadding="0" cellspacing="0">
<tr><td><input style="width:118px;" name="code" type="text" class="inputxt" id="code" maxlength="4" datatype="p" nullmsg="请输入验证码！" errormsg="验证码有误！" /></td><td><label id="send_sms"><a href="javascript:void(0);">获取验证码</a></label></td></tr>
</table></td></tr>
<tr><td></td><td colspan="2"><button type="submit" class="cm_but btu_next">&nbsp;</button></td></tr></table></form></div>
</td></tr></table>
</div></div>
<div class="index_right"><div class="right_box">
<?php $this->load->view('public/mod_yxb');?>
<div class="right_ad"><a href="http://www.pft06.com/" target="_blank"><img src="<?php echo $img_url;?>ads/index_ad.jpg" /></a></div> 
</div></div><!--清除浮动--><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>