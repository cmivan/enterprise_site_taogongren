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
<?php /*?>绑定日期<?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url?>plus_cal/plus.cal.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url?>plus_cal/plus.cal.css" />
<script language="JavaScript" type="text/javascript">
$(function(){
	var sdata=getSdate();
	var edata=getEdate();
	<?php
	if(!empty($date_go)){
		echo "var date_go = '".$date_go."';";
	}else{
		echo "var date_go = sdata;";
	}
	if(!empty($date_end)){
		echo "var date_end = '".$date_end."';";
	}else{
		echo "var date_end = sdata;";
	}
	?>
	$('#date_go').simpleDatepicker({ chosendate: date_go , startdate: sdata, enddate: edata });
	$('#date_end').simpleDatepicker({ chosendate: date_end , startdate: sdata, enddate: edata });
	//------------------
	$('#set_id_info').load('<?php echo site_url($s_urls.'/edit_check')?>?set_id=<?php echo $set_id?>');
	
	<?php if(!empty($ad_file)&&$ad_file!=''){?>
	view_upload();
	<?php }?>
});
function view_upload()
{
	var set_id = $('#set_id').val();
	var ad_file = $('#ad_file').val();
	if(ad_file!=''){
		$('#ad_file_view').fadeOut();
		$('#ad_file_view').load('<?php echo site_url($s_urls.'/ad_file_view');?>?ad_file='+ad_file+'&set_id='+set_id,
			function(){ $(this).fadeIn(350); });
	}
}
</script>
<style>
#set_id_info {line-height:150%; }
#set_id_info hr{ border:0; border-bottom:#999 1px solid; border-top:#eee 1px solid; }
</style>
</head>
<body>
<br>
<form class="validform" method="post">
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:650px;"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw">
<td height="25" colspan="2" align="center" style="color:#CC0000"><?php echo $action_name;?> <strong><?php echo $table_title;?></strong> 信息</td></tr>
<tr class="forumRow">
<td align="right">投放位置：</td><td align="left">
<input name="set_id" type="hidden" id="set_id" value="<?php echo $set_id;?>" /><strong><?php echo $ad_set_view?></strong>
</td></tr>
<tr class="forumRow">
<td align="right">用户ID：</td>
<td><input name="uid" type="text" id="uid" value="<?php echo $uid;?>"  <?php if(is_num($id)){echo 'disabled';}?> />
<?php /*?>&nbsp;<a href="javascript:alert(0);">+ 选择用户 +</a><?php */?></td></tr>
<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">广告链接：</td>
<td class="red"><label><input name="link" type="text" id="link" size="50" value="<?php echo $link;?>" /> 
  注：根据情况设定，可留空
</label></td></tr> 
<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">广告简述：</td>
<td><label><input name="note" type="text" id="note" size="50" value="<?php echo $note;?>" /></label></td></tr> 
<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">上传文件：</td>
<td class="red">
<iframe width="430" height="28" frameborder="0" scrolling="no" src="<?php echo site_url($s_url.'system_uploads')?>?keyid=ad_file"></iframe>
</td></tr> 

<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">广告预览：</td>
<td class="red"><div id="ad_file_view">Loading...</div><input name="ad_file" type="hidden" id="ad_file" value="<?php echo $ad_file;?>" /></td></tr>   

<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">开始日期：</td>
<td class="red"><label><input name="date_go" type="text" id="date_go" value="<?php echo $date_go;?>" <?php if(is_num($id)){echo 'disabled';}?>/> 
注：开始日期不能从当天开始
</label></td></tr>   

<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td">结束日期：</td>
<td><label><input name="date_end" type="text" id="date_end" value="<?php echo $date_end;?>" <?php if(is_num($id)){echo 'disabled';}?>/></label></td></tr>

<tr class="forumRow">
<td width="60" align="right" class="edit_box_edit_td red">注：</td>
<td><div id="set_id_info"></div></td></tr>


<tr class="forumRaw">
  <td height="30" align="center"><input type="button" class="button" value="返回" id="edit_back"/></td>
  <td class="edit_box_save_but" style="text-align:left">
  <input type="submit" name="button" id="save_button" value="" class="save_but" />
  <input type="hidden" name="id" id="id" value="<?php echo $id;?>" /></td>
</tr></table>
</td></tr></table>
</form>

<br>
</body>
</html>