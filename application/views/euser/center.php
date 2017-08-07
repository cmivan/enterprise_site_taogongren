<?php $this->load->view('public/center_header'); ?>
</head><body>
<!--头部-->
<?php $this->load->view('public/top'); ?>
<div class="main_width">
<div class="body_main" id="user_center">
<div class="my_left">

<!--左边导航-->
<div class="my_left_nav">
<?php ajax_url($title='个人信息', $c_urls.'/userinfo' );?>
<?php ajax_url($title='我的钱包', $c_url.'wallet' );?>
<?php ajax_url($title='我的收藏', $c_url.'favorites' );?>
<?php ajax_url($title='我的好友', $c_url.'friends' );?>
<div class="clear line">&nbsp;</div>
<?php ajax_url($title='我的投标', $c_url.'retrieval' );?>
<?php ajax_url($title='订单信息', $c_url.'orders_door' );?>
<?php ajax_url($title='消息管理', $c_url.'msg' );?>
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