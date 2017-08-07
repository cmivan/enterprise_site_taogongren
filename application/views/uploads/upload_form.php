<script type="text/javascript" src="<?php echo $jq_url?>"></script>
<script type="text/javascript">$(function(){ $('#userfile').change(function(){ $('form').submit(); }); });</script>
<style>body,table,div,td{ margin:0; font-size:12px; }</style>
<?php echo form_open_multipart($s_urls.'/do_upload');?>
<table border="0" cellpadding="0" cellspacing="0">
<tr><td><input type="file" name="userfile" id="userfile" style="border:#CCC 1px solid; width:233px;"/></td>
<td>&nbsp;支持gif|jpg|png|swf，小于1M</td></tr></table>
<input type="hidden" name="keyid" value="<?php echo $keyid?>"/>
</form>