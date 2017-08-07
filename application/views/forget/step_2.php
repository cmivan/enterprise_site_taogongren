<?php $this->load->view('public/header'); ?>
<?php /*?>注册表单<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_form.css" /></head>
<body>
<?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="10"><tr><td valign="top" class="page_main_title"><div style="float:left;">找回密码！(第二步)</div><div style="float:right; background:none;">或者请 <a href="javascript:void(0);" class="user_login">登录</a></div></td></tr><tr><td valign="top"><div class="tipbox">
请输入您注册时填写的手机号码，我们将会把您验证码发到你的手机上 再进行下一步操作。</div></td></tr><tr><td height="245" valign="top" class="page_main_content"><br>
<div class="diy_form" style="padding-left:80px;"><form class="validform"><table border="0" cellpadding="0" cellspacing="3"><tr><td><div class="val_left"></div></td><td><div class="val_center"></div></td><td><div class="val_right"></div></td></tr><tr>
  <td>新密码：</td>
  <td><input type="password" name="userpassword" class="inputxt" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间,不能使用空格！" /></td>
  <td><div class="validform_checktip">密码范围在6~16位之间,不能使用空格</div></td></tr>
<tr>
  <td>确认新密码：</td>
  <td><input type="password" name="userpassword2" class="inputxt" datatype="*" recheck="userpassword" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" /></td>
  <td><div class="validform_checktip">两次输入密码需一致</div></td></tr>
<tr>
  <td></td>
  <td colspan="2"><button type="submit" class="cm_but btu_next">&nbsp;</button></td></tr></table></form>
</div>
</td></tr></table>

</div>


</div>
<div class="index_right"><div class="right_box">
<?php $this->load->view('public/mod_yxb');?>
<div class="right_ad"><a href="http://www.pft06.com/" target="_blank"><img src="<?php echo $img_url;?>ads/index_ad.jpg" /></a></div> 
 </div></div><!--清除浮动--><div class="clear"></div>
  </div>
</div>
<?php $this->load->view('public/footer');?>