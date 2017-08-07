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

<?php if(!empty($view)){?> 
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">投标信息详情</td>
</tr>  
<tr class="forumRaw">
<td align="right" class="edit_box_edit_td">投标ID：</td>
<td class="td_padding">&nbsp;&nbsp;<?php echo $view->id?></td>
</tr>

<tr class="forumRow">
<td align="right" class="td_padding">发布用户：</td>
<td class="td_padding"><?php echo $this->User_Model->links($view->uid);?></td>
</tr>

<tr class="forumRaw">
<td align="right">浏览/参与人数：</td>
<td class="td_padding">&nbsp;&nbsp;<?php echo $view->visited?>/<?php echo $this->Retrieval_Model->election_num($view->id);?></td>
</tr>
<tr class="forumRow">
<td align="right">发布时间：</td>
<td class="td_padding"><?php echo $view->addtime?></td>
</tr>

<tr class="forumRaw">
  <td align="right">投标描述：</td>
  <td class="td_padding">&nbsp;&nbsp;<?php echo $view->note?></td>
</tr>
<tr class="edit_item_frist">
  <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php }?>


<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="80" align="center"><input type="button" class="button" value="返回" id="edit_back"/></td>
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td>
<td width="54%" align="right">
<form name="search" method="post" action="<?php echo reUrl('page=null')?>">
<table border="0" cellpadding="0" cellspacing="0" class="forum2">
<tr class="forumRaw2"><td><input name="keysword" type="text" id="keysword" value="<?php echo $keysword;?>" size="25" maxlength="20" /></td>
<td><input type="submit" name="Submit" value="&nbsp;<?php echo $table_title;?>搜索&nbsp;" class="button"/></td></tr>
</table>
</form>
</td></tr></table>

<form name="edit" method="post" action="">

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">编号</td>
<td align="center" class="edit_box_edit_td">参与个人或团队</td>
<td align="center">留言</td>
<td align="center" style="width:60px;">是否显示</td>
<td align="center" style="width:60px;">状态</td>
<td align="center" class="edit_box_edit_td">参与时间</td>
<td align="center" style="width:60px;">操作</td>
</tr>  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
		$note = $rs->note;
		$note2 = cutstr($note,20);
?> 

<tr class="forumRow"><td width="40" align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td width="40" align="center"><?php echo $rs->id;?></td>
<td align="left" class="td_padding"><?php echo $this->User_Model->links($rs->uid);?></td>
<td align="left" class="td_padding"><?php echo $rs->note?></td>
<td align="center">
<?php
if($rs->show==1){
	echo '<span title="显示" class="green">&radic;</span>';
}else{
	echo '<strong title="用户选择了隐藏留言" class="red">-</strong>';
}
?>
</td>
<td align="center">
<?php
if($rs->ok==1){
	echo '<span title="已中标" class="red">中标 <span class="green">&radic;</span></span>';
}else{
	echo '<strong title="未中标">-</strong>';
}
?>
</td>
<td align="center" title="<?php echo $rs->addtime?>"><?php echo dateHi($rs->addtime)?></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $note2?>' value="删除" />
</td></tr>

<?php }?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="14">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="8" align="center">暂无相应参与信息!</td></tr>
<?php }?>
</table>

</form>

</td></tr></table>
</body>
</html>