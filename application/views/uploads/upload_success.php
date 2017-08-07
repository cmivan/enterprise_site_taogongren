<?php
$keyid = $upload_data['upload_keyid'];
$file_name = $upload_data['file_name'];
$upload_date = $upload_data['upload_date'];
?>
<script type="text/javascript" src="<?php echo $jq_url?>"></script>
<script type="text/javascript">
$(function(){
var pobj = $(window.parent.document);
pobj.find('#<?php echo $keyid?>').val('<?php echo $upload_date.'/'.$file_name?>');
window.parent.view_upload();
alert('上传成功!');
});
</script>
<style>body,table,div,td{ margin:0; font-size:12px; }</style>
<div style="padding:7px;">
上传成功! (<?php echo dateTime()?>)<a href="<?php echo site_url($s_url.'system_uploads');?>?keyid=<?php echo $keyid?>">[重新上传]</a>
</div>
