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
		var p_id = $(this).attr('p_id');
		$('#cmd').val(cmd);
		$('#p_id').val(p_id);
		$(this).parents().find('.validform').submit();
		return false;
      });
  });
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td align="center"><?php echo $table_title;?> 管理列表
&nbsp;
<a href="<?php echo site_url($s_urls.'/province_edit')?>"><img src="<?php echo site_url_fix('public/system_style/images/ico/tree_explode','gif');?>" alt="添加分类" border="0" align="absmiddle" /> 添加 <span class="red"><?php echo $table_title;?></span></a>
</td></tr></table>



<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow"><td valign="top" class="type_ico">&nbsp;&nbsp;分域</td>
<td valign="top" class="td_padding">
<a href="?">全部</a>
<?php
if(!empty($place_regions)){
	foreach($place_regions as $rs){
?>&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->r_id==$r_id){?>
<a href="?r_id=<?php echo $rs->r_id?>" class="type_nav_on"><?php echo $rs->r_name?></a>
<?php }else{?>
<a href="?r_id=<?php echo $rs->r_id?>"><?php echo $rs->r_name?></a>
<?php }?>
<?php }}?>
</td></tr></table>

<form class="validform" method="post">
<input type="hidden" name="cmd" id="cmd" />
<input type="hidden" name="p_id" id="p_id" />
<input type="hidden" name="go" id="go" value="yes" />
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td align="center" width="40">编号</td>
<td align="center">省份名称</td>
<td align="center" style="width:80px;">城市数目</td>
<td align="center" style="width:80px;">地区数目</td>
<?php /*?><td align="center" style="width:80px;">人数</td><?php */?>
<td align="center" class="edit_box_edit_td">下级城市</td>

<?php if(is_num($r_id)==false){?>
<td width="40" align="center">排序</td>
<?php }?>

<td align="center" class="edit_box_edit_td">操作</td></tr>
<?php
if(!empty($place_provinces)){
	foreach($place_provinces as $rs){
		$city_num = $this->Place->province2city_num($rs->p_id);
?>
<tr class="forumRow">
<td align="center"><?php echo $rs->p_id;?></td>
<td class="td_padding">&nbsp;&nbsp;<?php echo $rs->p_name?></td>
<td align="center" class="td_padding"><?php echo $city_num?></td>
<td align="center" class="td_padding"><?php echo $this->Place->province2area_num($rs->p_id)?></td>
<?php /*?><td align="center" class="td_padding"><?php echo $rs->order_id?></td><?php */?>
<td align="center" class="td_padding">
<a href="<?php echo site_url($s_url.'place_city/city_edit')?><?php echo reUrl('p_id='.$rs->p_id.'&id=null')?>">添加</a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($city_num<=0){?>
<span style="text-decoration:line-through; color:#666">查看</span>
<?php }else{?>
<a href="<?php echo site_url($s_url.'place_city')?><?php echo reUrl('p_id='.$rs->p_id)?>">查看</a>
<?php }?>
</td>

<?php if(is_num($r_id)==false){?>
<td width="40" align="center">
  <a href="javascript:void(0);" class="order_btu" cmd="up" p_id="<?php echo $rs->p_id?>">
  <img src="<?php echo site_url_fix('public/system_style/images/ico/up_ico','gif');?>" border="0" /></a>
  <a href="javascript:void(0);" class="order_btu" cmd="down" p_id="<?php echo $rs->p_id?>">
  <img src="<?php echo site_url_fix('public/system_style/images/ico/down_ico','gif');?>" border="0" /></a>
</td>
<?php }?>

<td align="center">
<input style="display:none" type="button" class="button delete" url='<?php echo reUrl('del_id='.$rs->p_id)?>' title='<?php echo $rs->p_name;?>' value="删除" />
<input type="button" class="button update" url='<?php echo site_url($s_urls.'/province_edit')?><?php echo reUrl('id='.$rs->p_id)?>' value="修改"/>
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