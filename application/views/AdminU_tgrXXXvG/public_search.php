<?php
if(empty($keysword)){ $keysword=''; }
if(empty($table_title)){ $table_title=''; }
//if(empty($page)){ $page='null'; }
$page='null';
if(empty($p_id)){ $p_id='null'; }
if(empty($c_id)){ $c_id='null'; }
if(empty($a_id)){ $a_id='null'; }
//<?php echo reUrl('page=null')
?>
<form name="search" method="get" action="">
<table border="0" cellpadding="0" cellspacing="0" class="forum2">
<tr class="forumRaw2"><td><input name="keysword" type="text" id="keysword" value="<?php echo $keysword?>" size="25" maxlength="20" /></td>
<td><input type="submit" name="Submit" value="&nbsp;<?php echo $table_title;?>搜索&nbsp;" class="button"/></td></tr>
</table>
<input type="hidden" name="page" value="<?php echo $page?>"/>
<input type="hidden" name="p_id" value="<?php echo $p_id?>"/>
<input type="hidden" name="c_id" value="<?php echo $c_id?>"/>
<input type="hidden" name="a_id" value="<?php echo $a_id?>"/>
</form>