<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist"><td align="center" valign="top">称呼</td><td align="center" valign="top">性别</td><td align="center">手机</td><td align="center">QQ</td><td align="center">邮箱</td><td width="80" align="center">介绍时间</td><td width="40" align="center">状态</td><td width="60" align="center">操作</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr">
  <td align="center"><?php echo $rs->nicename?></td>
  <td align="center"><?php echo $rs->sex?></td>
  <td align="center"><?php echo $rs->mobile?></td>
  <td align="center"><?php echo $rs->qq?></td>
  <td align="center"><?php echo $rs->email?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center">
  
  <?php if($rs->ok==1){?>
  <span class="green tip" title="该信息已审核，并赠送<span class=chenghong>5</span>个淘工币！">&radic;</span>
  <?php }elseif($rs->ok==2){?>
  <span class="red tip" title="该用户没有注册成为淘工人！">&times;</span>
  <?php }else{?>
  <span class="red tip" title="未审核！">-</span>
  <?php }?>
    
  </td><td align="center">
<?php if($rs->ok!=1&&$rs->ok!=2){?>
<?php echo ajax_delurl('删除这项介绍信息',$rs->id,$img_url.'my/ico/del.gif');?>
<?php }else{?>-<?php }?>
</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="8" class="edit_item_none">暂无信息</td></tr><tr><td colspan="8" class="yzpage_line"></td></tr><?php }?></table>
<div class="clear"></div></div><?php $this->paging->links(); ?><div class="clear"></div></div></div>