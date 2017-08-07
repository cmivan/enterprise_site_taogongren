<?php /*?>表单<?php */?><?php $this->load->view('public/validform'); ?>
<form class="validform" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
<tr><td width="60">收信人：</td><td width="320"><?php echo $links?>
<input type="hidden" id="uid" name="uid" value="<?php echo $uid?>" /></td>
</tr><tr><td colspan="2">
<span><textarea name="note" rows="4" id="note" style="width:100%; height:60px;" nullmsg="请填写信息内容!" errormsg="至少5个字,最多70个字!" datatype="*5-70" ></textarea></span>
<span><div class="validform_checktip"></div></span>
</td></tr>
<tr><td colspan="2" align="right"><div style="position:relative;"><input style="position:absolute;top:-24px; right:0;" class="cm_but btu_send" id="send_msg_btu" type="submit" align="absmiddle" value="" /></div></td></tr>
</table>
</form>