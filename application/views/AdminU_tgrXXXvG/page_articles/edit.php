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
<br>
<form class="validform" method="post">
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1"><tr><td>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw">
<td height="25" colspan="2" align="center" style="color:#CC0000"><?php echo $action_name;?> <strong><?php echo $table_title;?></strong> 信息</td></tr>
<tr class="forumRow"><td width="60" align="right">标题：</td>
<td><label><input name="title" type="text" id="title" size="50" value="<?php echo $title;?>" /></label></td></tr>
<tr class="forumRow">
<td align="right">类别：</td><td>
<label>
<select name="type_id" id="type_id">
<?php
if(!empty($this_types)){
	foreach($this_types as $rs){
?>
<option value="<?php echo $rs->t_id?>" <?php if($type_id==$rs->t_id){echo "selected";}?> > <?php echo $rs->t_title?></option>
<?php }}?>
</select>

</label></td></tr>        
<tr class="forumRow">
<td align="right" valign="top">内容：</td><td> 
<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->system_js('content',$content,'88%','400px');?>
</td></tr><tr class="forumRaw">
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