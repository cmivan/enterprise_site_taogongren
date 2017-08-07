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
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td><td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow"><td valign="top" class="type_ico">&nbsp;&nbsp;分类</td>
<td valign="top" class="td_padding">
<a href="?">全部</a>
<?php
if(!empty($this_types)){
	foreach($this_types as $rs){
?>&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->t_id==$type_id){?>
<a href="?type_id=<?php echo $rs->t_id?>" class="type_nav_on"><?php echo $rs->t_title?></a>
<?php }else{?>
<a href="?type_id=<?php echo $rs->t_id?>"><?php echo $rs->t_title?></a>
<?php }?>
<?php }}?>
</td></tr></table>
<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td width="40">&nbsp;</td>
<td width="40" align="center">编号</td>
<td>&nbsp;文章标题</td>
<td width="80" align="center">查看次数</td>
<td align="center" class="edit_box_edit_td">添加日期</td>
<td align="center" class="edit_box_edit_td">操作</td>
</tr>
	  
	  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
?> 
<tr class="forumRow"><td align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td align="center"><?php echo $rs->id;?></td>
<td>&nbsp;<a href="<?php echo site_url('ver/urlto');?>?url=unions/view/<?php echo $rs->id?>" target="_blank" title="<?php echo $rs->title;?>"><?php echo cutstr($rs->title,26);?></a></td>
<td align="center"><?php echo $rs->visited;?></td>
<td align="center" title="<?php echo $rs->time;?>"><?php echo dateHi($rs->time);?></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo cutstr($rs->title,26);?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
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
</body>
</html>