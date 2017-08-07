<?php $this->load->view('public/header');?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>company/company_style.css" />

<?php if(1==2){?>
<link rel="stylesheet" href="<?php echo $css_url?>screen.css" type="text/css" media="screen" /><?php /*?>LightBox v2.0<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>mod_lightbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../../../public/style/mod_star.css" /><?php /*?>评级打分<?php */?>
<link rel="stylesheet" type="text/css" href="../../../../public/style/fullcalendar/fullcalendar.css" /><?php /*?>排期日历<?php */?>
<link rel="stylesheet" type="text/css" href="../../../../public/style/company/company_style.css" />
<?php }?>
 
</head><body><?php $this->load->view('public/top');?><div class="main_width">
<div class="body_main" style="padding:0; margin:0;">
<div id="wrapper">
<?php $this->load->view('user/company/header');?>
<div class="box"><ul class="menu"><?php echo $company_nav?></ul></div>
<div class="content"><div class="block_type_120" id="block_30428"><div class="nei bd newbd">
<!-- 最新图片列表 -->
<div class="newimg taogongren" style="padding-top:8px;">
<?php if(!empty($lists)){?>
<ul class="pic_img">
<?php foreach($lists as $item){?>
<li><a href="javascript:void(0);"><img src="<?php echo img_certificate($this,$item->pic)?>" width="210" height="140"></a></li>
<?php }?>
</ul>
<div class="clear"></div>
<div style="padding:2px; padding-left:10px; padding-bottom:10px;"><?php $this->paging->links(); ?></div>
<?php }else{?>
<div class="jianjie"><div style="padding:80px;text-align:center;">暂未找到相关信息!</div></div>
<?php }?>
</div>

</div></div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>