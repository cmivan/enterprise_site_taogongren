<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td colspan="2" align="left">&nbsp;简述</td>
  <td width="150" align="center">添加时间</td>
  <td width="100" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td colspan="2"><?php echo $rs->note?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center">
<?php echo ajax_delurl('删除这项排期',$rs->id,$img_url.'my/ico/del.gif');?>
&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/edit/".$rs->id)?>" class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>