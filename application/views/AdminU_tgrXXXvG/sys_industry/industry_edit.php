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
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:350px;"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw">
<td height="25" colspan="2" align="center" style="color:#CC0000"><?php echo $action_name;?> <strong><?php echo $table_title;?></strong> 信息</td></tr>
<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">分类：</td>
<td><?php echo $select_classid?></td></tr>
<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">所属工种：</td><td><?php echo $select_industryid?></td></tr>
<tr class="forumRow"><td width="60" align="right" class="edit_box_edit_td">技能项目名称：</td>
<td><label><input name="title" type="text" id="title" value="<?php echo $title;?>" size="30" /></label></td></tr>

<?php /*?>
<tr class="forumRow" style="display:none">
<td align="right">&nbsp;</td>
<td><table border="0" cellpadding=0 cellspacing=1 class="forum">
<tr class="forumin"><td><label>
<input name="recommen" type="checkbox" id="recommen" value="yes" <?php if($r_recommen=="yes"){echo "checked";};?> />
</label></td>
<td width="40" align="center">推荐</td>
<td align="center"><label>
<input name="popular" type="checkbox" id="popular" value="yes" <?php if($r_popular=="yes"){echo "checked";};?>/>
</label>
</td>
<td width="40" align="center">热门</td>
<td align="right"><table border="0" cellspacing="0" cellpadding="0">
<tr class="forumRow">
<td width="45" align="center">来源</td><td>
<input name="come" type="text" class="input" id="come" value="<?php echo $r_come;?>" size="15" /></td>
</tr></table></td>
</tr></table></td>
</tr>
<?php */?>

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