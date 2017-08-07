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
<div class="content">
<div class="block_type_120" id="block_30428"><div class="nei bd newbd">
<!-- 自定义文字内容 -->
<div class="jianjie"><?php echo $note;?></div>

</div></div></div><div class="content"><div class="block_type_120" id="block_30429"><div class="tit hd">服务项目<span class="ntel clearfix"><?php echo $cardnum?></span></div><div class="nei bd ">

<!-- 自定义文字内容 -->
<div class="jianjie"><?php echo $team_fwxm;?></div>
</div></div></div>

<div class="content"><div class="block_type_21" id="block_30430"><div class="tit hd">最新案例<span class="ntel clearfix"><?php echo $cardnum?></span>
<span class="ntel clearfix" style=" margin-left:540px; width:70px;background:none;"><a href="<?php echo $nav_more['cases']?>"><img src="/public/images/ico/more.jpg" width="51" height="15"></a></span>
</div><div class="nei bd "><!-- 最新图片列表 --><div class="newimg block_30430">

<?php if(!empty($cases)){?>
<ul class="pic_img">
<?php foreach($cases as $item){?>
<li><a href="javascript:void(0);"><img src="<?php echo img_cases($item->pic)?>" width="210" height="140"></a></li>
<?php }?>
</ul>
<?php }else{?>
<div class="jianjie"><div style="padding:80px;text-align:center;">暂未找到相关信息!</div></div>
<?php }?>

</div></div></div></div>

<div class="content"><div class="block_type_21" id="block_30430"><div class="tit hd">荣誉证书<span class="ntel clearfix"><?php echo $cardnum?></span>
<span class="ntel clearfix" style=" margin-left:540px; width:70px;background:none;"><a href="<?php echo $nav_more['certificate']?>"><img src="/public/images/ico/more.jpg" width="51" height="15"></a></span></div><div class="nei bd "><!-- 最新图片列表 --><div class="newimg block_30430">

<?php if(!empty($certificates)){?>
<ul class="pic_img">
<?php foreach($certificates as $item){?>
<li><a href="javascript:void(0);"><img src="<?php echo img_certificate($item->pic)?>" width="210" height="140"></a></li>
<?php }?>
</ul>
<?php }else{?>
<div class="jianjie"><div style="padding:80px;text-align:center;">暂未找到相关信息!</div></div>
<?php }?>

</div></div></div></div>
<div class="content"><div class="block_type_120" id="block_30431"><div class="tit hd">参考价格<span class="ntel clearfix"><?php echo $cardnum?></span></div><div class="nei bd ">

<!-- 自定义文字内容 --><div class="jianjie"><?php echo $team_ckbj;?></div>

</div></div></div>

<?php /*?><div class="content"><div class="block_type_100" id="block_30433"><div class="tit hd">电子地图<span class="ntel clearfix"><?php echo $cardnum?></span></div><div class="nei bd "><!-- 电子地图 --><div class="map"><div id="map_container"></div></div><script type="text/javascript">
var viewMap = {
	cityName : '北京',
	lngLat : '39.86044,116.359913',
	address : '北京市丰台区右安门'
};</script></div></div></div><?php */?>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>