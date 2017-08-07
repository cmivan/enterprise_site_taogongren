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
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td><td align="right">
<form name="search" method="post" action="<?php echo reUrl('page=null')?>">
<table border="0" cellpadding="0" cellspacing="0" class="forum2">
<tr class="forumRaw2"><td><input name="keysword" type="text" id="keysword" value="<?php echo $keysword;?>" size="25" maxlength="20" /></td>
<td><input type="submit" name="Submit" value="&nbsp;<?php echo $table_title;?>搜索&nbsp;" class="button"/></td></tr>
</table>
</form>
</td></tr></table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow">
<td valign="top" class="type_ico">&nbsp;&nbsp;类别</td>
<td valign="top" class="td_padding">
<a href="<?php echo reUrl('classid=null');?>">全部</a>
<?php
if(!empty($this_class)){
	foreach($this_class as $rs){
?>&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->id==$classid){?>
<a href="<?php echo reUrl('classid='.$rs->id);?>" class="type_nav_on"><?php echo $rs->title?></a>
<?php }else{?>
<a href="<?php echo reUrl('classid='.$rs->id);?>"><?php echo $rs->title?></a>
<?php }?>
<?php }}?>
</td></tr></table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow"><td valign="top" class="type_ico">&nbsp;&nbsp;工种</td>
<td valign="top" class="td_padding">
<a href="<?php echo reUrl('industryid=null');?>">全部</a>
<?php
if(!empty($this_types)){
	foreach($this_types as $rs){
?>&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->id==$industryid){?>
<a href="<?php echo reUrl('industryid='.$rs->id);?>" class="type_nav_on"><?php echo $rs->title?></a>
<?php }else{?>
<a href="<?php echo reUrl('industryid='.$rs->id);?>"><?php echo $rs->title?></a>
<?php }?>
<?php }}?>
</td></tr></table>

<?php if($edit_tip!=''){?>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRow">
<td align="left" class="td_padding red">
<strong>操作结果：</strong> <a href="<?php echo reUrl('del_id=null')?>">[关闭]</a><?php echo $edit_tip?></td></tr></table>
<?php }?>

<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">编号</td>
<td>&nbsp;工种名称</td>
<td align="center" class="edit_box_edit_td">使用人数</td>
<td align="center" class="edit_box_edit_td">操作</td>
</tr>
	  
	  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
?> 
<tr class="forumRow"><td width="40" align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td width="40" align="center"><?php echo $rs->id;?></td>
<td>&nbsp;<?php echo keycolor($rs->title,$keysword);?></td>
<td align="center"><?php echo $this->Skills_Model->skills_user_num($rs->id)?></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $rs->title;?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/industry_edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td></tr>
<?php }?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="5">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->Paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="6" align="center">暂无相应内容!</td></tr>
<?php }?>
</table>
</form>
</td></tr></table>
</body>
</html>