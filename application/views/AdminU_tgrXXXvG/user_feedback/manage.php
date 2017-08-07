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
<br />
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1"><tr><td>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td><td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>


<form name="edit" method="post" action="">
  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
?> 
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
	
<tr class="forumRaw edit_item_frist">
<td width="40">&nbsp;</td>
<td width="40" align="center">编号</td>
<td align="center">&nbsp;昵称</td>
<td align="center">邮箱地址</td>
<td align="center">QQ</td>
<td align="center">IP</td>
<td align="center">留言时间</td>
<td align="center" class="edit_box_edit_td">操作</td>
</tr>

<tr class="forumRaw"><td align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td align="center"><?php echo $rs->id;?></td>
<td align="center"><?php echo $rs->nicename?> <?php if(is_num($rs->uid)){?>(<?php echo $this->User_Model->links($rs->uid)?>)<?php }?></td>
<td align="center"><?php echo $rs->email?></td>
<td align="center"><?php echo $rs->qq?></td>
<td align="center"><?php echo $rs->ip?></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $rs->nicename?>' value="删除" />
</td></tr>

<tr class="forumRow">
  <td height="80" colspan="8" align="left" valign="top" style="padding:4px; padding-left:12px;">
  <strong>留言内容：</strong> <?php echo $rs->content?></td>
</tr>

</table>
<?php }?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="11">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->paging->links(); ?></td>
</tr></table>
</TD></tr>
</table>

<?php }else{?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td width="40">&nbsp;</td>
<td width="40" align="center">编号</td>
<td align="center">&nbsp;昵称</td>
<td align="center">邮箱地址</td>
<td align="center">QQ</td>
<td align="center">IP</td>
<td align="center">留言时间</td>
<td align="center" class="edit_box_edit_td">操作</td>
</tr>
<tr class="forumRow"><td height="50" colspan="12" align="center">暂无相应内容!</td></tr>
</table>

<?php }?>

</form>

</td></tr></table>
</body>
</html>