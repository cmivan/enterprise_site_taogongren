<?php if(!empty($this_types)){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2 forumtop">
<TR class="forumRow"><td valign="top" class="type_ico">&nbsp;&nbsp;分类</td>
<td valign="top" class="td_padding">
<a href="?">全部</a>
<?php foreach($this_types as $rs){?>
&nbsp;&nbsp;|&nbsp;&nbsp;
<?php if($rs->t_id==$type_id){?>
<a href="<?php echo reUrl('page=null&type_id='.$rs->t_id)?>" class="type_nav_on"><?php echo $rs->t_title?></a>
<?php }else{?>
<a href="<?php echo reUrl('page=null&type_id='.$rs->t_id)?>"><?php echo $rs->t_title?></a>
<?php }}?>
</td></tr></table>
<?php }?>