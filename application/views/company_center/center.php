<?php $this->load->view('public/center_header'); ?>
</head><body>
<!--头部-->
<?php $this->load->view('public/top'); ?>
<div class="main_width">
<div class="body_main" id="user_center">
<div class="my_left">
<!--左边导航-->
<div class="my_left_nav">
<?php ajax_url($title='企业信息', $c_urls.'/companyinfo' );?>
<?php ajax_url($title='资质证书', $c_url.'certificate' );?>
<?php ajax_url($title='案例展示', $c_url.'cases' );?>
<?php ajax_url($title='工人管理', $c_url.'member' );?>
<div class="clear line">&nbsp;</div>
<?php ajax_url($title='我的钱包', $c_url.'wallet' );?>
<?php ajax_url($title='我的投标', $c_url.'retrieval' );?>
<?php ajax_url($title='我的收藏', $c_url.'favorites' );?>
<?php ajax_url($title='我的好友', $c_url.'friends' );?>
<div class="clear line">&nbsp;</div>
<?php ajax_url($title='投放广告', $c_url.'ads' );?>
<?php ajax_url($title='订单信息', $c_url.'orders_door' );?>
<?php ajax_url($title='消息管理', $c_url.'msg' );?>
<?php ajax_url($title='招聘求职', $c_url.'recruitment' );?>
<div class="clear line">&nbsp;</div>
<a href="<?php echo site_url("user/".$logid)?>" cmd='null' target="_blank">预览主页</a>
<a href='<?php echo site_url("action/logout")?>' cmd='null' class='user_login_out'>退出管理</a>
<div class="clear"></div>
</div></div>
<div class="my_right">
<!--遮罩层-->
<div id="user_center_box_mark">
<div id='mark_load'>
<div id="mark_load_txt">载入中，请稍等...</div><img src="<?php echo $img_url.'loadingAnimation.gif'?>" /></div>
</div>
<!--内容区-->
<div id="user_center_box"></div>
</div>
<div class="clear"></div>
</div></div>
<!--底部-->
<?php $this->load->view('public/footer');?>