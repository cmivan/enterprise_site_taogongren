<?php
//-=================================================-
//-====  |       伊凡php建站系统 v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-04-02 11:00    | ====-
//-====  |       For    : 齐翔广告             | ====-
//-=================================================-
?>
<?php $this->load->view_system('header'); ?>
</head>

<body style="overflow:hidden">
<br />
<form class="validform" method="post">
<TABLE border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:400px;"><tr><td>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2">
<tr class="forumRaw edit_item_frist">
  <td colspan="2" align="center"><?php echo $action_name?>省份</td></tr>
<tr class="forumRow">
<td align="right">&nbsp;&nbsp;&nbsp;所属区域：</td>
<td><?php echo $select_r_id?></td></tr>
<tr class="forumRow">
<td align="right">省份名称：</td>
<td><input type="text" name="p_name" id="p_name"  value="<?php echo $p_name?>"/>&nbsp;</td></tr>
<tr class="forumRow"><td align="right">排序：</td>
<td><input type="text" name="order_id" id="order_id"  value="<?php echo $order_id?>"/>&nbsp;</td></tr>
<tr class="forumRow">
  <td colspan="2" align="center" class="red">注：排序数字 大于1， 越大越靠前</td>
  </tr>
<tr class="forumRaw">
<td colspan="2" align="center">
  <input type="button" class="button" value="返回" id="edit_back"/>
  <input type="submit" class="button2" id="save_button" value="提交"/>
  <input type="hidden" name="p_id" id="p_id"  value="<?php echo $p_id?>"/>
  </td>
</tr></table>
</td></tr></table>
</form>
</body>
</html>