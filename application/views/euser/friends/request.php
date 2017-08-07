<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>

<div class="my_right"><div class="mainbox" box="content_box"><?php /*?>好友页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td align="left">&nbsp;用户</td>
  <td width="200" align="center">添加时间</td>
  <td width="150" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>

<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="left"><?php echo $this->User_Model->links($rs->fuid);?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center">
  <a href="?id=<?php echo $rs->id?>&cmd=del" class="tip item_del" title="删除该消息"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
  &nbsp;
  <a href="?id=<?php echo $rs->id?>&cmd=ok" class="tip" title="同意他的好友请求，并加他为好友！">同意加为好友</a>
  &nbsp;
  <a href="?id=<?php echo $rs->id?>&cmd=black" class="tip" title="把他拉到黑名单，以免骚扰！">拉黑</a>
  </td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div></div>
<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>