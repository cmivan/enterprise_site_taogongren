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
	$('.order_btu').click(function(){
		var cmd = $(this).attr('cmd');
		var type_id = $(this).attr('type_id');
		$('#cmd').val(cmd);
		$('#type_id').val(type_id);
		$(this).parents().find('.validform').submit();
		return false;
      });
  });
</script>
</head>
<body>
<br />
<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="type_id" id="type_id" />
<input type="hidden" name="go" id="go" value="yes" />
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:500px;"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td colspan="2" align="center">
  <a href="<?php echo site_url($s_urls.'/type_edit')?>">
  <img src="<?php echo site_url_fix('public/system_style/images/ico/tree_explode','gif');?>" alt="添加分类" border="0" align="absmiddle" />
    添加 <span class="red"><?php echo $table_title;?></span> 类别
  </a></td>
<td width="40" align="center">排序</td>
<td align="center" class="edit_box_edit_td">操作</td></tr>
<?php
if(!empty($this_types)){
	foreach($this_types as $rs){
?>
<tr class="forumRow">
<td width="25" align="center"><img src="<?php echo site_url_fix('public/system_style/images/ico/file','gif');?>" border="0" />
</td><td class="td_padding">&nbsp;&nbsp;<?php echo $rs->t_title?><span>(<?php echo $rs->t_id?>)</span>
</td><td width="40" align="center">
<a href="javascript:void(0);" class="order_btu" cmd="up" type_id="<?php echo $rs->t_id?>">
<img src="<?php echo site_url_fix('public/system_style/images/ico/up_ico','gif');?>" border="0" /></a>
<a href="javascript:void(0);" class="order_btu" cmd="down" type_id="<?php echo $rs->t_id?>">
<img src="<?php echo site_url_fix('public/system_style/images/ico/down_ico','gif');?>" border="0" /></a>
</td>
<td align="center">
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->t_id)?>' title='<?php echo $rs->t_title;?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/type_edit')?><?php echo reUrl('id='.$rs->t_id)?>' value="修改"/>
</td>
</tr>
<?php }}?>

</table></td>
  </tr>
</table>
</form>
</body>
</html>