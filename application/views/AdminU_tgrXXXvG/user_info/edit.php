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
<style type="text/css">.validform select{ 180px; }</style>
</head>
<body>
<br>
<form class="validform" method="post">
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:auto;"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td height="25" colspan="3" align="center" style="color:#CC0000"><?php echo $action_name;?> <strong><?php echo $table_title;?></strong> 信息</td></tr>

<tr class="forumRow">
<td align="right">性别：&nbsp;&nbsp;</td><td>
&nbsp;
<?php
$sex_girl = '';
$sex_boy  = '';
if($sex==1){
   $sex_girl=" checked=checked ";
}else{
   $sex_boy =" checked=checked ";
}
?>
<label><input name="sex" type="radio" id="sex" value="0" <?php echo $sex_boy?> class="putong"> 
男</label>
&nbsp;&nbsp;<label><input name="sex" type="radio" id="sex" value="1" <?php echo $sex_girl?> class="putong"> 
女</label>
</td><td>&nbsp;</td></tr>


<tr class="forumRaw"><td align="right" class="edit_box_edit_td">昵称：&nbsp;&nbsp;</td><td><input name="name" type="text" class="inputxt" value="<?php echo $name?>" maxlength="6" datatype="s2-6" nullmsg="请填写昵称！" errormsg="昵称应为2～6个字符！"  /></td><td style="width:200px;"><div class="validform_checktip">昵称应为2～6个字符</div></td></tr>

<?php if($id){?>
<tr class="forumRow"><td align="right" class="edit_box_edit_td">手机：&nbsp;&nbsp;</td><td><input disabled type="text" class="inputxt" value="<?php echo $mobile?>" /></td><td>&nbsp;</td></tr>
<?php }else{?>
<tr class="forumRow"><td align="right" class="edit_box_edit_td">手机：&nbsp;&nbsp;</td><td><input name="mobile" type="text" class="inputxt" id="mobile" value="<?php echo $mobile?>" datatype="m" nullmsg="请填写用户的手机号！" errormsg="请填写正确的手机号码！"/></td><td><div class="validform_checktip">请填写用户的手机号！</div></td></tr>
<?php }?>

<tr class="forumRaw">
<td align="right" class="edit_box_edit_td">邮箱：&nbsp;&nbsp;</td>
<td><input name="email" type="text" class="inputxt" id="email" value="<?php echo $email?>" /></td><td>&nbsp;</td>
</tr>

<tr class="forumRow"><td align="right">从业时间：&nbsp;&nbsp;</td><td>
<?php echo $select_entry_age?>
</td><td>&nbsp;</td></tr>

<tr class="forumRaw"><td align="right" class="edit_box_edit_td">QQ/MSN：&nbsp;&nbsp;</td><td><input name="qq" type="text" class="inputxt" id="qq" value="<?php echo $qq?>" /></td><td>&nbsp;</td></tr>
   
<tr class="forumRow">
<td align="right" valign="top">真实姓名：</td>
<td><input name="truename" type="text" id="truename" value="<?php echo $truename?>" class="inputxt"/></td>
<td>&nbsp;</td>
</tr>

<tr class="forumRaw"><td align="right" class="edit_box_edit_td">籍贯：&nbsp;&nbsp;</td>
<td class="val_place">
<?php echo $select_b_p_id;?>
<?php echo $select_b_c_id;?>
<?php echo $select_b_a_id;?>
</td><td>&nbsp;</td></tr>

<tr class="forumRow"><td align="right">现在住处：&nbsp;&nbsp;</td>
<td class="val_place">
<?php echo $select_p_id;?>
<?php echo $select_c_id;?>
<?php echo $select_a_id;?>
</td><td>&nbsp;</td>
</tr>

<tr class="forumRaw">
<td align="right">详细位置：&nbsp;&nbsp;</td>
<td><input name="address" type="text" id="address" value="<?php echo $address?>" class="inputxt" /></td>
<td>&nbsp;</td>
</tr>

<tr class="forumRow">
<td align="right" valign="top">个人简介：</td>
<td><textarea name="note" rows="8" id="note" style="width:280px;"><?php echo $note?></textarea></td>
<td>&nbsp;</td>
</tr>

<tr class="forumRaw">
<td height="30" align="center"><input type="button" class="button" value="返回" id="edit_back"/></td>
<td class="edit_box_save_but" style="text-align:left">
<input type="submit" name="button" id="save_button" value="" class="save_but" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" /></td>
<td class="edit_box_save_but" style="text-align:left">&nbsp;</td>
</tr>

</table>
</td></tr></table>
</form>

<br>
</body>
</html>