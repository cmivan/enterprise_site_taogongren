<?php $this->load->view('public/validform'); ?>
<?php /*?>
from: http://www.uploadify.com/demos/ 
problem: on upload , the session will change by CI and
solusions: http://codeigniter.org.cn/forums/thread-5760-1-1.html<?php */?>

<?php uploadify_js('certificate',1);?>

<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table width="576" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="2"><div class="edit_box_main"></div></td></tr>
<tr><td colspan="2">标题：<span class="edit_box_spen">(标题至少4个字符,最多28个字符)</span></td></tr><tr><td width="168"><input name="title" type="text" class="inputxt" id="title" value="<?php echo $info->title?>" maxlength="28" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" /></td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr><td colspan="2"><div style="position:relative;"><div style="position:absolute; left:105px; top:2px;"><table border="0" cellpadding="0" cellspacing="0"><tr><td style="width:1px;"><input type="hidden" name="pic" id="pic" value="<?php echo $info->pic?>" nullmsg="请上传图片！" datatype="*" /></td><td><div class="validform_checktip"></div></td></tr></table></div></div><div id="upload_img"></div><div id="upload_img_show"><img src="<?php echo img_certificate($this,$info->pic);?>" style="width:200px;" /></div></td></tr><tr><td colspan="2">证书简述：</td></tr><tr><td colspan="2" class="val_place"><textarea id="content" name="content" datatype="*" style="width:90%;height:85px;"><?php echo $info->content?></textarea></td></tr><tr><td colspan="2"><input type="submit" class="save_but" value="" /></td></tr></table></form></div></div>