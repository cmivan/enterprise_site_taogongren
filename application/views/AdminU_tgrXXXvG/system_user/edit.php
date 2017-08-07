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

</head>
<body>
<br>
<form class="validform" method="post">
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:450px"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw">
<td height="25" colspan="2" align="center" style="color:#CC0000"><?php echo $action_name;?> <strong><?php echo $table_title;?></strong> 信息</td></tr>
<tr class="forumRow">
  <td align="right" class="td_padding">帐号ID：</td>
<td><label><input name="username" type="text" id="username" value="<?php echo $username?>" /></label></td></tr>
<tr class="forumRow">
<td align="right">登录密码：</td>
<td><label><input name="password" type="password" id="password" value="<?php echo $password?>" /></label></td></tr>

<tr class="forumRow">
<td align="right">确认密码：</td>
<td><label><input name="password2" type="password" id="password2" value="" /></label></td></tr>

<tr class="forumRaw">
<td height="30" align="center"><input type="button" class="button" value="返回" id="edit_back"/></td>
<td class="edit_box_save_but" style="text-align:left">
<input type="submit" name="button" id="save_button" value="" class="save_but" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" /></td>
</tr></table>
</td></tr></table>
</form>

<br>
</body>
</html>