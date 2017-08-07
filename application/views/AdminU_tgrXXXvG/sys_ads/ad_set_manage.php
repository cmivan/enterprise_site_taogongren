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
		var set_id = $(this).attr('set_id');
		$('#cmd').val(cmd);
		$('#set_id').val(set_id);
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
<input type="button" class="button update" style="color:#F00" url='<?php echo site_url($s_urls.'/ad_set_edit')?>' value=" +增加 <?php echo $table_title;?> 位置+ "/>
</td>
<td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>

<?php if(!empty($ad_pages)){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow">
  <td valign="top" class="type_ico">&nbsp;&nbsp;页面</td>
<td valign="top" class="td_padding">
<a href="?">全部</a>
<?php foreach($ad_pages as $rs){?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->id==$page_id){?>
<a href="<?php echo reUrl('page=null&page_id='.$rs->id)?>" class="type_nav_on"><?php echo $rs->title?></a>
<?php }else{?>
<a href="<?php echo reUrl('page=null&page_id='.$rs->id)?>"><?php echo $rs->title?></a>
<?php }}?>
</td></tr></table>
<?php }?>

<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="set_id" id="set_id" />
<input type="hidden" name="go" id="go" value="yes" />
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td width="40" align="center">编号</td>
<td class="td_padding">&nbsp;位置描述</td>
<td width="100" align="center">历史投放次数</td>
<td width="80" align="center">待开始数</td>
<td width="60" align="center">宽(px)</td>
<td width="60" align="center">高(px)</td>
<td width="80" align="center">状态</td>
<td width="40" align="center">排序</td>
<td align="center" style="width:200px;">操作</td></tr>
<?php
if(!empty($list)){
	foreach($list as $rs){
?>
<tr class="forumRow">
<td width="40" align="center"><?php echo $rs->id?></td>
<td class="td_padding">&nbsp;&nbsp;<?php echo keycolor($rs->title,$keysword)?></td>
<td align="center"><?php echo $this->Ads_Model->ad_lists_ok_num($rs->id);?></td>
<td align="center"><?php echo $this->Ads_Model->ad_lists_waitting_num($rs->id);?></td>
<td align="center"><?php echo $rs->size_w?></td>
<td align="center"><?php echo $rs->size_h?></td>
<td align="center">
<?php if($this->Ads_Model->ad_set_ing($rs->id)){echo '<b class=red>展示期</b>';}else{echo '等待期';}?>
<?php if($rs->isshow==0){echo '，隐藏';}?>
</td>
<td width="40" align="center">
  <a href="javascript:void(0);" class="order_btu" cmd="up" set_id="<?php echo $rs->id?>">
    <img src="<?php echo site_url_fix('public/system_style/images/ico/up_ico','gif');?>" border="0" /></a>
  <a href="javascript:void(0);" class="order_btu" cmd="down" set_id="<?php echo $rs->id?>">
    <img src="<?php echo site_url_fix('public/system_style/images/ico/down_ico','gif');?>" border="0" /></a>
</td>
<td align="center">
<input type="button" class="button update" url='<?php echo site_url($s_urls)?><?php echo reUrl('set_id='.$rs->id)?>' value="管理广告"/>
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/edit')?><?php echo reUrl('set_id='.$rs->id)?>' value="投放广告"/>
<?php /*?>
<input type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->id)?>' title='<?php echo $rs->title;?>' value="删除" /><?php */?>
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/ad_set_edit')?><?php echo reUrl('id='.$rs->id)?>' value="修改"/>
</td>
</tr>
<?php }?>
<tr class="forumRow"><td colspan="9" align="center"><?php $this->Paging->links(); ?></td></tr>
<?php }else{?>
<tr class="forumRow"><td height="50" colspan="9" align="center">暂无相应内容!</td></tr>
<?php }?>

</table>
</form>
</body>
</html>