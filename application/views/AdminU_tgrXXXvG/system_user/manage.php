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
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td>
<td width="50%" align="center" class="edit_box_edit_td">
<input type="button" class="button update" style="color:#F00" url='<?php echo site_url($s_urls.'/edit')?>' value=" +添加管理员帐号+ "/>
</td>
<td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>
<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td align="center" colspan="2">编号</td>
<td>&nbsp;帐号</td>
<!--<td align="center"><?php /*?>管理权限范围<?php */?>&nbsp;</td>-->
<td width="100" align="center" class="edit_box_edit_td">添加日期</td>
<td width="100" align="center" class="edit_box_edit_td">操作</td>
</tr>
	  
	  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
?> 
<?php if($rs->super==1){?>
<tr class="forumRow"><td width="40" align="center">
<input type="checkbox" disabled /></td>
<td width="40" align="center"><?php echo $rs->id;?></td>
<td>&nbsp;<?php echo keycolor($rs->username,$keysword)?></td>
<!--<td align="center"><?php /*?><?php echo $rs->power?><?php */?></td>-->
<td align="center" title="<?php echo $rs->addtime;?>"><?php echo dateHi($rs->addtime);?></td>
<td align="center">
<input type="button" class="button" disabled value="删除" style="background:none; cursor:default; color:#999;" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td></tr>
<?php }else{?>
<tr class="forumRow"><td width="40" align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td width="40" align="center"><?php echo $rs->id;?></td>
<td>&nbsp;<?php echo keycolor($rs->username,$keysword)?></td>
<!--<td align="center"><?php /*?><?php echo $rs->power?><?php */?>&nbsp;</td>-->
<td align="center" title="<?php echo $rs->addtime;?>"><?php echo dateHi($rs->addtime);?></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $rs->username?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td></tr>
<?php }}?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="7">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="6" align="center">暂无相应内容!</td></tr>
<?php }?>
</table>
</form>
</body>
</html>