<div class="mainbox" box="content_box">
<?php /*?>钱包页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?><div class="info">
&nbsp;&nbsp; 淘工币：<label class="chenghong"><?php echo $cost_T?></label> 个
&nbsp;&nbsp; 现金账户：<label class="chenghong"><?php echo $cost_S?></label> 元</div></div>
<div class="mainbox_box"><div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="40" align="center">编号</td>
  <td>&nbsp;说明</td>
  <td width="64" align="center">金额</td>
  <td width="120" align="center">时间</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><?php if($rs->costype=="T"){$costype="淘工币";}else{$costype="元";}?><tr class="edit_item_tr">
  <td align="center"><?php echo $rs->id?></td>
  <td><?php if($rs->costype=="S_XY"){echo '<img src="views/images/ico/xin.gif" />';}?>&nbsp;&nbsp;<?php echo $rs->note?></td>
  <td align="center"><span class="chenghong"><?php echo $rs->cost?></span> <?php echo $costype?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php
}}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><?php }?></table>


<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>