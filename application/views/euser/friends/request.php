<div class="mainbox" box="content_box"><?php /*?>好友页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td align="left">&nbsp;用户</td>
  <td width="200" align="center">添加时间</td>
  <td width="150" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>

<?php if(!empty($list)){?><?php foreach($list as $rs){?>
<tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->fuid);?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center">
<?php echo ajax_delurl('删除该消息','cmd=del&id='.$rs->id,$img_url.'my/ico/del.gif')?>
&nbsp;
<a href="<?php echo reUrl('cmd=ok&id='.$rs->id,1)?>" tip="同意他的好友请求，并加他为好友！">同意加为好友</a>
&nbsp;
<a href="<?php echo reUrl('cmd=black&id='.$rs->id,1)?>" tip="把他拉到黑名单，以免骚扰！">拉黑</a>
</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>