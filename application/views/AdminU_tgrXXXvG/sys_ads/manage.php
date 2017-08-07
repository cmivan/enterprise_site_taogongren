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
<td width="100%" align="center"><?php echo $table_title;?> 列表</td><td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>

<?php if(!empty($ad_sets)){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow">
  <td valign="top" class="type_ico">&nbsp;&nbsp;位置</td>
<td valign="top" class="td_padding">
<a href="?">全部</a>
<?php foreach($ad_sets as $rs){?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->id==$set_id){?>
<a href="<?php echo reUrl('page=null&set_id='.$rs->id)?>" class="type_nav_on"><?php echo $rs->title?></a>
<?php }else{?>
<a href="<?php echo reUrl('page=null&set_id='.$rs->id)?>"><?php echo $rs->title?></a>
<?php }}?>
</td></tr></table>
<?php }?>

<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">编号</td>
<td>&nbsp;广告简述</td>
<td align="center" class="edit_box_edit_td">&nbsp;投放用户</td>
<?php /*?><td width="80" align="center">查看次数</td><?php */?>
<td align="center" class="edit_box_edit_td">开始日期</td>
<td align="center" class="edit_box_edit_td">结束日期</td>
<td width="70" align="center">投放天数</td>
<td align="center" class="edit_box_edit_td">创建日期</td>
<td align="center" class="edit_box_edit_td">状态</td>
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
<td>&nbsp;<?php echo keycolor(cutstr($rs->note,26),$keysword);?></td>
<td>&nbsp;
  <?php echo $this->User_Model->links($rs->uid);?></td>
<?php /*?><td align="center"><?php echo $rs->visited;?></td><?php */?>
<td align="center"><?php echo dateHi($rs->date_go);?></td>
<td align="center"><?php echo dateHi($rs->date_end);?></td>
<td align="center"><strong class="red"><?php echo $rs->date_day;?></strong></td>
<td align="center"><?php echo dateHi($rs->addtime);?></td>
<td align="center">
<?php
$date_go = strtotime($rs->date_go);
$date_end = strtotime($rs->date_end);
if($date_go>time()){
	echo '未开始';
}elseif($date_go<=time()&&$date_end>time()){
	echo '<b class=red>进行中</b>';
}else{
	echo '<span style="text-decoration:line-through;color:#999">已过期</span>';
}
?>
</td>
<td align="center">
  <input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo cutstr($rs->note,26);?>' value="删除" />
  <input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td></tr>
<?php }?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="10">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->Paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="11" align="center">暂无相应内容!</td></tr>
<?php }?>
</table>
</form>
</body>
</html>