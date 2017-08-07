<?php $this->load->view('public/validform'); ?>
<?php /*?>复制代码<?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url?>clipboard/ZeroClipboard.js"></script>
<script language="javascript" type="text/javascript">
var clip = null;
$(function(){init();});
function init() {
	clip = new ZeroClipboard.Client();
	clip.setHandCursor( true );
	clip.addEventListener('load', function (client) {});
	clip.addEventListener('mouseOver', function (client) {
	clip.setText($('#url').val());});
	clip.addEventListener('complete', function (client, text) {
		  var thisTXT=$("#url").val();
		  if(thisTXT==text){
			$("#url").select();alert("链接复制成功!");
		  }else{
			alert("链接复制失败,请手动复制!");
		  }
	   });
	clip.glue('copy','d_clip_container');
	}
</script>
<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?>
<div class="mainbox_nav"><?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<form class="validform" method="post"><table width="576" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="2"><div class="edit_box_main"></div></td></tr>
<tr><td colspan="2"><div class="tipbox" style="font-size:13px;border:0; padding-bottom:5px; margin-top:10px;margin-bottom:20px; border:#FC0 1px solid;"><table border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2"><strong>该案例的评价链接：</strong></td></tr><tr>
<td><a style="color:#333;" href="<?php echo $case_link?>" cmd='null' target="_blank"><?php echo $case_link?></a>&nbsp;&nbsp;</td>
<td><input type="hidden" id="url" value="<?php echo $case_link?>" /><div id="d_clip_container" style="position:relative;"><a href="javascript:void(0);" id="copy" style=" color:#F00">[ 复制 ]</a></div></td></tr></table><?php //}else{?>
现在添加案例,可以生成评价链接！ 业主可以通过该链接对你评价。<?php //}?></div>
</td></tr>

<tr><td colspan="2">标题：<span class="edit_box_spen">(标题至少4个字符,最多28个字符)</span></td></tr><tr><td width="168">
<input type="text" name="title" class="inputxt" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" id="title" value="<?php echo $info->title?>" />
</td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr><td height="0" colspan="2" class="edit_box_main"></td></tr><tr><td colspan="2">内容：</td></tr><tr><td colspan="2" class="val_place">

<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js('content',$info->content,'100%','350px');?>

</td></tr><tr><td colspan="3" class="edit_box_save_but"><input type="submit" class="save_but" value="" /><input type="hidden" name="pic" value="0" /></td></tr></table></form></div></div>