<?php $this->load->view('public/validform'); ?>

<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?>
<div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<form class="validform" name="validform" id="validform" method="post"><table width="576" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="2"><div class="edit_box_main"></div></td></tr>

<tr><td colspan="2">标题：<span class="edit_box_spen">(标题至少4个字符,最多28个字符)</span></td></tr>
<tr><td width="168"><input name="title" type="text" class="inputxt" id="title" maxlength="28" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" /></td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr><td height="0" colspan="2"></td></tr><tr><td colspan="2">内容：</td></tr><tr><td colspan="2" class="val_place">

<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js('content','','100%','350px');?>

</td></tr><tr><td colspan="2"><input type="submit" class="save_but" value="" /><input type="hidden" name="pic" value="0" /></td></tr></table></form>
</div></div>