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
		var a_id = $(this).attr('a_id');
		$('#cmd').val(cmd);
		$('#a_id').val(a_id);
		$(this).parents().find('.validform').submit();
		return false;
      });
  });
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><strong class="red">【<?php echo $c_name?>】</strong> 下级<?php echo $table_title?> 管理列表，
&nbsp; <a href="<?php echo site_url($s_urls.'/area_edit')?><?php echo reUrl('id=null')?>"><img src="<?php echo site_url_fix('public/system_style/images/ico/tree_explode','gif');?>" alt="添加分类" border="0" align="absmiddle" /> 添加<strong class="red">【<?php echo $c_name?>】</strong>下级<?php echo $table_title;?></a></td>
<td align="center"><input type="button" class="button" value="返回" id="edit_back"/></td>
</tr>
</table>
<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="c_id" id="c_id" value="<?php echo $c_id?>" />
<input type="hidden" name="a_id" id="a_id" />
<input type="hidden" name="go" id="go" value="yes" />
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td align="center" width="40">编号</td>
<td>&nbsp;地区名称</td>
<?php /*?><td align="center" style="width:80px;">人数</td><?php */?>
<td width="40" align="center">排序</td>
<td align="center" class="edit_box_edit_td">操作</td></tr>
<?php
if(!empty($place_area)){
	foreach($place_area as $rs){
?>
<tr class="forumRow">
<td align="center"><?php echo $rs->a_id;?></td>
<td class="td_padding">&nbsp;&nbsp;<?php echo $rs->a_name?></td>
<?php /*?><td align="center" class="td_padding"><?php echo $rs->order_id?></td><?php */?>
<td width="40" align="center">
  <a href="javascript:void(0);" class="order_btu" cmd="up" a_id="<?php echo $rs->a_id?>">
  <img src="<?php echo site_url_fix('public/system_style/images/ico/up_ico','gif');?>" border="0" /></a>
  <a href="javascript:void(0);" class="order_btu" cmd="down" a_id="<?php echo $rs->a_id?>">
  <img src="<?php echo site_url_fix('public/system_style/images/ico/down_ico','gif');?>" border="0" /></a>
</td>
<td align="center">
<input style="display:none" type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->a_id)?>' title='<?php echo $rs->a_name;?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/area_edit')?><?php echo reUrl('id='.$rs->a_id)?>' value="修改"/>
</td>
</tr>
<?php }}?>
<tr class="forumRaw edit_item_frist">
<td colspan="9" align="center">&nbsp;</td>
</tr>

</table>
</form>

</body>
</html>