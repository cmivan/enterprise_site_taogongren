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
		var page_id = $(this).attr('page_id');
		$('#cmd').val(cmd);
		$('#page_id').val(page_id);
		$(this).parents().find('.validform').submit();
		return false;
      });
  });
</script>
</head>
<body>

<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td>
<td width="50%" align="center" class="edit_box_edit_td">
<input type="button" class="button update" style="color:#F00" url='<?php echo site_url($s_urls.'/ad_page_edit')?>' value=" +增加 <?php echo $table_title;?> 页面+ "/>
</td>
<td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>

<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="page_id" id="page_id" />
<input type="hidden" name="go" id="go" value="yes" />
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td width="40" align="center">编号</td>
<td class="td_padding">&nbsp;页面描述</td>
<td width="40" align="center">排序</td>
<td align="center" style="width:200px;">操作</td></tr>
<?php
if(!empty($ad_pages)){
	foreach($ad_pages as $rs){
?>
<tr class="forumRow">
<td width="25" align="center"><?php echo $rs->id?></td>
<td class="td_padding">&nbsp;&nbsp;<?php echo keycolor($rs->title,$keysword)?></td>
<td width="40" align="center">
  <a href="javascript:void(0);" class="order_btu" cmd="up" page_id="<?php echo $rs->id?>">
    <img src="<?php echo site_url_fix('public/system_style/images/ico/up_ico','gif');?>" border="0" /></a>
  <a href="javascript:void(0);" class="order_btu" cmd="down" page_id="<?php echo $rs->id?>">
    <img src="<?php echo site_url_fix('public/system_style/images/ico/down_ico','gif');?>" border="0" /></a>
</td>
<td align="center">
<input type="button" class="button update" url='<?php echo site_url($s_urls)?><?php echo reUrl('page_id='.$rs->id)?>' value="管理位置"/>
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/ad_page_edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td>
</tr>
<?php }}?>

</table>
</form>
</body>
</html>