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
<script>
$(function(){
  $(".item_yes").click(function(){
		  var thisid =$(this).parent().attr("id");
		  if(parseInt(thisid)==thisid){
			  if(confirm("确定该推荐信息有效并奖励推荐人淘工币吗？")){
				  window.location.href="?cmd=yes&id="+thisid+"&page=<?php echo $page?>";return true;}}							 
		  });
  $(".item_no").click(function(){
		  var thisid =$(this).parent().attr("id");
		  if(parseInt(thisid)==thisid){
			  if(confirm("确定该推荐信息无效？")){
				  window.location.href="?cmd=no&id="+thisid+"&page=<?php echo $page?>";return true;}}							 
		  });
});
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td><td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>
<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">编号</td>
<td align="center">&nbsp;用户</td>
<td align="center">性别</td>
<td align="center">手机</td>
<td align="center">QQ</td>
<td align="center">添加时间</td>
<td align="center">推荐人</td>
<td align="center">状态</td>
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
<td>&nbsp;<?php echo $rs->nicename?></td>
<td align="center"><?php echo $rs->sex?></td>
<td align="center"><?php echo $rs->mobile?></td>
<td align="center"><?php echo $rs->qq?></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center"><?php echo $this->User_Model->links($rs->uid)?></td>
<td align="center"><?php echo $this->Introduce_Model->stats($rs->ok)?></td>
<td align="center" id="<?php echo $rs->id?>">
<?php if($rs->ok==0){?>
<a href="javascript:void(0);" class="item_yes" title="这条信息有用，赠送推荐人淘工币！"><span class="green">&radic;</span></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="item_no" title="这条信息没什么用！"><span class="red">&times;</span></a>
<?php }else{ echo '-'; }?>
</td></tr>
<?php }?>
<tr class="forumRaw"><td align="center"><input id="del_checkbox" type="checkbox" /></TD>
<td colspan="11">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
<tr>
<td width="80"><input type="submit" value="删除选中项" id="Submit_delsel" class="button" /></td>
<td><?php $this->Paging->links(); ?></td>
</tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="12" align="center">暂无相应内容!</td></tr>
<?php }?>
</table>
</form>
</body>
</html>