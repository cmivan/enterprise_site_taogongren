<?php $this->load->view('public/header'); ?>
<?php /*?>编辑器<?php */?>
<script charset="utf-8" src="<?php echo $edit_url?>k/kindeditor.js"></script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table width="576" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="2"><div class="edit_box_main"></div></td></tr><tr><td colspan="2">标题：<span class="edit_box_spen">(标题至少4个字符,最多28个字符)</span></td></tr>
<tr><td width="168"><input name="title" type="text" class="inputxt" id="title" maxlength="28" nullmsg="标题不能为空！" errormsg="标题至少4个字符,最多28个字符" datatype="s4-28" value="<?php if(!empty($info->title)){echo $info->title;}?>" /></td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr><td height="0" colspan="2"></td></tr><tr><td colspan="2">内容：</td></tr><tr><td colspan="2" class="val_place"><script>
KE.show({
   id : 'content',
   resizeMode : 1,
   allowPreviewEmoticons : false,
   allowUpload : true,
   items : [
   'image','|', 
   'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'underline',
   'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
   'insertunorderedlist']
   });</script><textarea id="content" name="content" datatype="*" style="width:100%;height:210px;visibility:hidden;"><?php if(!empty($info->content)){echo $info->content;}?></textarea></td></tr><tr><td colspan="2"><input type="submit" class="save_but" value="" /></td></tr></table></form>
</div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>