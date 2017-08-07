<?php $this->load->view('public/validform'); ?>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table width="576" border="0" align="center" cellpadding="0" cellspacing="3"><tr><td width="567"><div class="edit_box_main"></div></td></tr>
<tr><td height="0"></td></tr><tr>
<td>请填写<strong>服务项目</strong>内容：<span style="color:#CCC">（要注意字数和排版美观哦！）</span></td></tr><tr><td class="val_place">

<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js('content',$content,'100%','250px');?>

</td></tr><tr><td><input type="submit" class="save_but" value="" /></td></tr></table></form>
</div></div>