<?php $this->load->view('public/validform'); ?>
<?php /*?>绑定日期<?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>plus_cal/plus.cal.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>plus_cal/plus.cal.css" /><script language="JavaScript" type="text/javascript">
$(function(){
	var sdata=getSdate();
	var edata=getEdate();
	$('#s_date').simpleDatepicker({ chosendate: sdata , startdate: sdata, enddate: edata });
	$('#e_date').simpleDatepicker({ chosendate: sdata , startdate: sdata, enddate: edata });
});</script>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table width="650" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3"><div class="edit_box_main"></div></td></tr>
<tr><td height="30" colspan="3"><div class="tipbox">广告位 <b class="chenghong">1</b> 元/天/条 , 请注意字数限制。</div></td></tr>
  <tr><td height="0" colspan="2" class="edit_box_main"></td></tr><tr>
  <td colspan="2">标题：<span class="edit_box_spen">(至少4个字,最多70个字)</span></td></tr><tr><td width="442"><input name="adtitle" type="text" class="inputxt" id="adtitle" style="width:97%" maxlength="28" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" /></td><td width="199"><div class="validform_checktip"></div></td></tr><tr><td height="0" colspan="2" class="edit_box_main"></td></tr><tr><td colspan="2">广告语：<span class="edit_box_spen">(至少4个字,最多28个字)</span></td></tr><tr><td class="val_place"><textarea name="adnote" rows="2" class="inputxt" id="adnote" style="width:97%" maxlength="28" nullmsg="内容不能为空！" errormsg="内容至少5个字符,最多70个字符" datatype="*5-70" ></textarea></td><td><div class="validform_checktip"></div></td></tr><tr><td height="0" colspan="2" class="edit_box_main"></td></tr>   <tr><td colspan="2">投放时间：</td></tr>     <tr><td class="val_place"><input name="s_date" type="text" style="width:40%" class="inputxt" id="s_date">
&nbsp;到 &nbsp;<input name="e_date" type="text" style="width:40%" class="inputxt" id="e_date"></td><td><div class="validform_checktip"></div></td></tr> 
        <tr><td colspan="3" class="edit_box_save_but"><input type="submit" class="save_but" value="" /></td></tr></table></form>
</div></div>