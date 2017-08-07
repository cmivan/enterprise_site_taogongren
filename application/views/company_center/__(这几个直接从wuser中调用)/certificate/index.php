<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<div class="content">
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tr class="edit_item_frist"><td align="center">证书</td><td width="350" align="center">&nbsp;证书名称</td><td width="120" align="center">添加时间</td><td width="70" align="center">操作</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="center"><div style="width:150px; overflow:hidden" title="点击查看大图" class="tip" ><a href="<?php echo img_certificate($this,$rs->pic);?>" cmd='null' target="_blank"><img src="<?php echo img_certificate($this,$rs->pic);?>" name="photo" height="20" border="0" id="photo"></a></div></td><td align="center">&nbsp;<?php echo $rs->title?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center">
<?php echo ajax_delurl('删除该证书',$rs->id,$img_url.'my/ico/del.gif');?>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">修改</a></td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="7" align="center" class="edit_item_none">暂无信息</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }?>
</table><div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>