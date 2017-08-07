<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<form class="validform" method="post"><table width="650" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3"><div class="edit_box_main"></div></td></tr>
<tr><td height="30" colspan="3"><div class="tipbox">广告位 <b class="chenghong">1</b> 元/天/条 , 请注意字数限制。</div></td></tr><tr><td height="0" colspan="2" class="edit_box_main"></td></tr><tr><td colspan="2">标题：<span class="edit_box_spen">(至少4个字符,最多28个字符)</span></td></tr><tr>
  <td width="442">
  <input name="adtitle" type="text" class="inputxt" id="adtitle" style="width:97%" value="<?php echo $info->title?>" maxlength="28" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" />
  </td>
  <td width="199"><div class="validform_checktip"></div></td></tr><tr><td height="0" colspan="2" class="edit_box_main"></td></tr><tr><td colspan="2">广告语：<span class="edit_box_spen">(至少4个字符,最多28个字符)</span></td></tr>
  <tr>
  <td class="val_place">
  <textarea name="adnote" rows="2" class="inputxt" id="adnote" style="width:97%" maxlength="28" nullmsg="内容不能为空！" errormsg="内容至少4个字符,最多28个字符" datatype="*4-28" ><?php echo $info->ad?></textarea></td>
  <td><div class="validform_checktip"></div></td></tr>
    <tr><td height="0" colspan="2" class="edit_box_main"></td></tr>    <tr><td colspan="2">投放时间：</td></tr>      <tr><td class="val_place"><input disabled name="s_date" type="text" style="width:40%" class="inputxt" id="s_date" value="<?php echo $info->s_date?>">
&nbsp;到 &nbsp;<input disabled name="e_date" type="text" style="width:40%" class="inputxt" id="e_date" value="<?php echo $info->e_date?>"></td><td><div class="validform_checktip"></div></td></tr> 
<tr><td colspan="3" class="edit_box_save_but"><input type="submit" class="save_but" value="" /></td></tr>
</table></form>
</div></div></div>
<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>