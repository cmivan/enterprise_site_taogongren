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
<script language="javascript">
$(function(){
	$('#p_id').change(function(){
			var p_id = $(this).val();
			window.location.href='?p_id='+p_id;
			});
	$('#c_id').change(function(){
			var p_id = $('#p_id').val();
			var c_id = $(this).val();
			window.location.href='?p_id='+p_id+'&c_id='+c_id;
			});
	$('#a_id').change(function(){
			var p_id = $('#p_id').val();
			var c_id = $('#c_id').val();
			var a_id = $(this).val();
			window.location.href='?p_id='+p_id+'&c_id='+c_id+'&a_id='+a_id;
			});
  });
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td>
<td width="20" align="center"><?php echo $select_p_id?></td>

<?php if(!empty($select_c_id)){?>
<td width="20" align="center"><?php echo $select_c_id?></td>
<?php }?>

<?php if(!empty($select_a_id)){?>
<td width="20" align="center"><?php echo $select_a_id?></td>
<?php }?>
<td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>

<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">编号</td>
<td width="150">&nbsp;企业昵称</td>
<td>&nbsp;企业全称</td>
<?php /*?>
<td width="60" align="center">淘工币</td>
<td width="60" align="center">实币</td>
<?php */?>
<td align="center">所在省</td>
<td align="center">所在市</td>
<td align="center">所在区</td>
<td align="center" class="edit_box_edit_td">录入或注册时间</td>
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
<td>&nbsp;<?php echo $this->User_Model->links($rs->id);?></td>
<td>&nbsp;<?php echo $rs->truename;?></td>
<?php /*?>
<td align="center"><?php echo $this->Records_Model->balance_cost($rs->id,"T")?></td>
<td align="center"><?php echo $this->Records_Model->balance_cost($rs->id,"S")?></td>
<?php */?>
<td align="center"><a href="?p_id=<?php echo $rs->p_id?>"><?php echo $this->Place->province_name($rs->p_id)?></a></td>
<td align="center"><a href="?p_id=<?php echo $rs->p_id?>&c_id=<?php echo $rs->c_id?>"><?php echo $this->Place->city_name($rs->c_id)?></a></td>
<td align="center"><a href="?p_id=<?php echo $rs->p_id?>&c_id=<?php echo $rs->c_id?>&a_id=<?php echo $rs->a_id?>"><?php echo $this->Place->area_name($rs->a_id)?></a></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center">
  <input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $rs->truename?>' value="删除" />
  <input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
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