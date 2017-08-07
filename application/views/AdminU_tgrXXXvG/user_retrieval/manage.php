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
<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<tr class="forumRaw edit_item_frist">
<td width="40">&nbsp;</td>
<td width="40" align="center">编号</td>
<td align="center">投标描述</td>
<td align="center" class="edit_box_edit_td">发布用户</td>
<td align="center" style="width:50px;">浏览</td>
<td align="center" style="width:50px;">参与</td>
<td align="center" class="edit_box_edit_td">发布时间</td>
<td align="center" style="width:60px;">管理投标</td>
<td align="center" style="width:60px;">操作</td>
</tr>  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
		$note1 = $rs->note;
		$note2 = cutstr($note1,40);
		$note3 = keycolor($note2,$keysword);
?> 

<tr class="forumRow"><td align="center">
<input class="del_id" name="del_id[]" type="checkbox" id="del_<?php echo $delnum;?>" value="<?php echo $rs->id;?>" /></td>
<td align="center"><?php echo $rs->id;?></td>
<td align="left" class="td_padding">
<div style="height:20px; overflow:hidden;">
<a href="<?php echo site_url('ver/urlto');?>?url=retrieval/view/<?php echo $rs->id?>" target="_blank" title="<?php echo $note1?>">
<?php echo keycolor(cutstr($note3,26),$keysword);?></a>
</div>
</td>
<td align="left" class="td_padding"><?php echo $this->User_Model->links($rs->uid);?></td>
<td align="center"><?php echo $rs->visited?></td>
<td align="center"><?php echo $this->Retrieval_Model->election_num($rs->id);?></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center"><a href="<?php echo site_url($s_urls.'/election')?><?php echo reUrl('rid='.$rs->id)?>" title="对参与该投标的信息管理">进入</a></td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $note2?>' value="删除" />
</td></tr>

<?php }?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="12">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->Paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="13" align="center">暂无相应内容!</td></tr>
<?php }?>
</table>
</form>
</body>
</html>