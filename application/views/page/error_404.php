<?php $this->load->view('public/header'); ?>
</head><body>
<br><br>
<div class="main_width"><div class="body_main"><div class="retrieval_left" style="background-color:#FEFAEF; text-align:center; border:#F90 1px solid; padding:5px; padding-top:20px; padding-left:0; padding-right:0;">
<div style="border:0; background:none; padding:5px;" id="smart_404"><img src="/public/images/error/404.jpg" width="744" height="255" /></div>
<div><table width="100%" border="0" cellpadding="0" cellspacing="10" style="background-image:none; padding-left:4px;"><tr><td height="80" align="center" class="page_projects_nav"><?php foreach($industrys as $rs){?><a href="<?php echo site_url("search")?>?industryid=<?php echo $rs->id?>" target="_blank"><img src="<?php echo base_url().$rs->pic?>" /><br /><?php echo $rs->title?></a><?php }?></td></tr></table></div><!--Çå³ı¸¡¶¯--><div class="clear"></div>
</div></div></div>
</body></html>