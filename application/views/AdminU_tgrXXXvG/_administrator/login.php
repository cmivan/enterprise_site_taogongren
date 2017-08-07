<?php
//-=================================================-
//-====  |       伊凡php建站系统 v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-04-02 11:00    | ====-
//-====  |       For    : 齐翔广告             | ====-
//-=================================================-
?>
<?php $this->load->view_system('header'); ?>
<script type="text/javascript">
var url = "<?php echo site_url("administrator/login/verifycode")?>?";
$(function(){ $('#verifycode').attr('src',url); });
function reload_vcode(v)
{
	var rand = Math.random();
	url += rand;v.src = url;
}
</script>
</head>
<body style="overflow:hidden">
<form class="validform" method="post">
<table width="100%" height="80%"  border="0" cellpadding="0" cellspacing="0"><tr>
<td height="80%" valign="middle"><br><br><br><br>
<TABLE style="width:auto; height:auto;" border="0" align="center" cellpadding="0" cellspacing="10" class="forum1">
<tr><td style="width:463px; height:230px;" valign="top" background="/public/system_style/images/login/manage_back1.jpg">
<table  border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:80px;">
<tr><td align="right">帐号：</td><td><input name="user" type="text" class="login_input" id="user" size="20" nullmsg="帐号不能为空！" errormsg="帐号至少2个字符,最多6个字符" datatype="*2-6" /></td><td width="225"><div class="validform_checktip"></div></td></tr><tr><td align="right">密码：</td><td><input name="pass" type="password" class="login_input" id="pass" size="20" maxlength="15" nullmsg="密码不能为空！" errormsg="密码不能为空" datatype="*" />
  
<?php /*?><input name="pass" type="password" class="login_input" id="pass" size="20" maxlength="15" nullmsg="密码不能为空！" errormsg="密码至少4个字符,最多28个字符" datatype="*4-28" /><?php */?>
</td><td><div class="validform_checktip"></div></td></tr><tr><td align="right">验证码：</td><td>
<input class="login_input" name="code" type="text" id="code" size="8" style="width:65px;" nullmsg="验证码不能为空！" errormsg="请输入正确的验证码！" datatype="p" />
<a href="javascript:void(0);"><img src="<?php echo site_url("administrator/login/verifycode")?>" alt="点击刷新" name="verifycode" height="20" border="0" align="absmiddle" class="code_img" id="verifycode" onClick="reload_vcode(this)" /></a></td><td width="225"><div class="validform_checktip"></div></td></tr><tr><td>&nbsp;</td><td class="edit_box_save_but" style="text-align:left;"><input type="submit" class="save_but" value="" /><input type="hidden" name="action" id="action"  value="do" /></td><td>&nbsp;</td></tr></table>
</td></tr></table></td></tr></table>
</form>
</body></html>
