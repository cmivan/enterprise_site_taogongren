<?php $this->load->view('public/validform'); ?>
<form class="validform" method="post"><table border="0" align="center" cellpadding="0" cellspacing="5"><tbody><tr><td height="10" colspan="3">在您绑定或换绑邮箱时，淘工人网会向您设定的登录邮箱发送验证邮件，请登录邮箱查收邮件并按邮件提示完成操作。</td></tr><tr><td height="1" colspan="3" align="right"></td></tr><tr><td align="right" valign="top" style="width:150px;vertical-align:top"><div style="height:30px; line-height:30px; width:72px;">邮箱地址：</div></td><td valign="top"><div style="height:30px; line-height:30px;"><input style="margin:0; width:220px;" name="email" type="text" id="email" value="<?php echo $email?>" class="inputxt" datatype="e" nullmsg="请输入邮箱！" errormsg="请填写正确的邮箱！" /></div><div><div class="validform_checktip" style="margin-left:0">请填写你需要绑定的邮箱</div></div></td><td valign="top" style="vertical-align:top"><div style="padding-top:3px;"><input class="cm_but btu_send" id="submit_but" type="submit" align="absmiddle" value="" /></div></td></tr></tbody></table></form>