<?php $this->load->view('public/header'); ?>
<?php /*?>绑定日期<?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url?>plus_cal/plus.cal.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url?>plus_cal/plus.cal.css" />
<script language="JavaScript" type="text/javascript">
$(function(){
	var sdata=getSdate();
	var edata=getEdate();
	$('#mytime').simpleDatepicker({ chosendate: sdata , startdate: sdata, enddate: edata });
});
</script>
</head><body>
<?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box">
<form class="validform" method="post">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="3">
<tr><td colspan="2">日期：<span class="edit_box_spen">这里选择日期</span></td></tr>
<tr><td width="168"><input name="mytime" type="text" class="inputxt" id="mytime" value="<?php echo $info->mytime?>" datatype="d" nullmsg="请选择日期！" /></td><td width="473"><div class="validform_checktip"></div></td></tr>
<tr><td colspan="2" class="edit_box_main"></td></tr>
<tr><td colspan="2">地点：<span class="edit_box_spen">这里填写工作地点</span></td></tr>
<tr>
  <td><input name="diqu" type="text" class="inputxt" id="diqu" value="<?php echo $info->diqu?>" maxlength="50" datatype="*5-70" nullmsg="请输入地点！" /></td>
  <td><div class="validform_checktip"></div></td></tr>
<tr><td colspan="2" class="edit_box_main"></td></tr><tr><td colspan="2">简述：<span class="edit_box_spen">这里填写工作简述</span></td></tr>
<tr>
  <td colspan="2"><input name="note" type="text" class="inputxt" id="note" style="width:90%;" value="<?php echo $info->note?>" maxlength="70" datatype="*5-70" nullmsg="请输入简述！">
  </td></tr><tr><td colspan="2"><input type="submit" class="save_but" value="" /></td></tr>
</table></form>
</div>
</div></div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>