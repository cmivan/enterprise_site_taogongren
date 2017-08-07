<div class="mainbox" box="content_box">
<div class="mainbox_nav"><a href="javascript:void(0);" cmd='null' class="on">管理收藏夹</a></div>
<div class="mainbox_box">
<div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr class="edit_item_frist">
<td align="left">&nbsp;用户</td>
<td width="200" align="center">收藏时间</td>
<td width="80" align="center">操作</td></tr>
<tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?>
<tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->fuid);?></td>
<td align="center"><?php echo dateYMD($rs->addtime)?></td>
<td align="center"><?php echo ajax_delurl('移出收藏夹',$rs->id,$img_url.'my/ico/del.gif');?></td>
</tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div><?php $this->paging->links(); ?><div class="clear"></div></div></div>