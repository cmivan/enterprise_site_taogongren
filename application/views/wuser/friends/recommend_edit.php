<?php $this->load->view('public/validform'); ?>
<form class="validform" method="post">
<br /><table width="100%" border="0" cellpadding="0" cellspacing="1"><tr>
<td height="30" align="right" class="class_title">用户：</td>
<td align="left" class="class_title">
<?php echo $this->User_Model->links($fuid);?>
<input type="hidden" name="fuid" value="<?php echo $fuid?>" />
</td></tr><?php if(!empty($info)){?><tr>
<td height="28" align="right" class="class_title" style="padding-top:12px; vertical-align:top">推荐理由：</td>
<td align="left" class="class_title"><div><input name="note" type="text" class="inputxt" id="note" value="<?php echo $info->note?>" maxlength="28" nullmsg="说明不能为空！" errormsg="说明至少4个字符,最多28个字符" datatype="s4-28"  /></div>
<div><div class="validform_checktip" style="margin-left:0">推荐理由至少4个字，之多28个字</div></div></td></tr><?php }else{?><tr><td height="28" align="right" class="class_title" style="padding-top:12px; vertical-align:top">推荐理由：</td><td align="left" class="class_title"><div><input name="note" type="text" class="inputxt" id="note" maxlength="28" nullmsg="说明不能为空！" errormsg="说明至少4个字符,最多28个字符" datatype="s4-28"  /></div><div><div class="validform_checktip" style="margin-left:0">推荐理由至少4个字，之多28个字</div></div></td></tr><?php }?><tr><td>&nbsp;</td><td><input type="submit" class="save_but" value="" /></td></tr></table></form>
