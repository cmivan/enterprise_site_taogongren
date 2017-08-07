<?php /*?>页面顶部<?php */?>
<div class="main_top_muen">
<div class="main_width">
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
<?php if($logid!=0){ //返回登录的状态和id ?>
<table border="0" cellpadding="0" cellspacing="0" id="userloginbox"><tr><td><li>
<?php /*?>Hi,&nbsp;<?php */?><?php echo greetings();?></li><li><div class="top_nav_user_face"><?php echo $this->User_Model->links($logid)?></div></li><li class="line">&nbsp;</li><li id="msg_btu"><a href="<?php echo site_url($c_url."msg");?>" class="ico">短消息<span>(<b>0</b>)</span></a></li><li class="line">&nbsp;</li><li><a href="<?php echo site_url($c_url."center");?>">管理中心</a></li><li class="line">&nbsp;</li><li><a href="<?php echo site_url("action/logout");?>" class="user_login_out">退出</a></li></td></tr></table><?php /*?>获取该用户的最新消息<?php */?><?php }else{?><table border="0" cellpadding="0" cellspacing="0" class="userloginbox"><tr><td width="150">欢迎来到淘工人网！<span style="display:none"><?php echo greetings();?></span></td><td>帐号：</td><td><input type="text" class="inputtext" id="username" /></td><td>密码：</td><td><input type="password" class="inputtext" id="password" /></td><td><button id="login_btu" class="cm_but btu_login_top">&nbsp;</button></td><td>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url("reg")?>">免费注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url("forget")?>" class="user_forget" title="忘记密码？">忘记密码？</a></td></tr></table><?php }?></td><td align="right" id="top_nav_right"><li><a href="<?php echo site_url("articles")?>" class="new_ico">装修学堂<span><b>news</b></span></a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="favorite">收藏本站</a></li><li class="line">&nbsp;</li><li><a href="<?php echo site_url("page/help")?>">帮助中心</a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="contact">联系我们</a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="user_feedback">意见反馈</a></li></td></tr></table></div></div>
<?php /*?>顶部主体<?php */?><div class="new_top new_main_width"><div class="top_box"><div class="top_city"><?php /*?>城市切换框<?php */?><div class="city_select"><?php /*?>城市<?php */?><div class="citys" style="margin-bottom:0;"><div id="title" class="off tip"  title="点击切换城市！" ><?php
$city=$placebox->city();
if(!empty($city)){?><a href="javascript:void(0);" id="<?php echo $city->c_id;?>"><?php echo $city->c_name;?></a><?php }?></div><div class="clear"></div></div><?php /*?>切换下拉框<?php */?><div class="provinces_citys_box"><div class="provinces_citys"><div class="quyu">
<?php
$place=$placebox->box();
if(!empty($place)){
	foreach($place as $rs){?><a href="javascript:void(0);" id="<?php echo $rs->r_id?>" <?php if($rs->r_id==$placebox->regionid):?>class="on"<?php endif?>><?php echo $rs->r_name?></a><?php }}?><div class="clear"></div></div><div id="quyu_box">
<?php
if(!empty($place)){
foreach($place as $rs){
	if(!empty($rs->provinces)){
		foreach($rs->provinces as $p_rs){?><div <?php if($p_rs->num%2==1){echo "class=item";}else{echo "class=item2";}?>><div class="provinces"><?php echo $p_rs->p_name?></div><div class="areas"><?php if(!empty($p_rs->citys)){
	foreach($p_rs->citys as $c_rs){?><a href="javascript:void(0);" id="<?php echo $c_rs->c_id?>"><?php echo $c_rs->c_name?></a><?php }}?></div><div class="clear"></div></div><?php }}}}?><div class="clear"></div></div></div></div></div></div><div class="top_nav_search"><?php /*?>导航栏目<?php */?><div class="top_nav"><a class="nav_1" href="<?php echo site_url("index")?>">淘首页</a><a class="nav_2" href="<?php echo site_url("search")?>">淘工人</a><a class="nav_3" href="<?php echo site_url("info")?>">淘信息</a><a href="http://mall.taogongren.com" target="_blank" class="nav_4">淘材料</a><a class="nav_5" href="<?php echo site_url("unions")?>">淘工会</a></div><div class="top_search"><div class="seach">
<div class="seach_box">
<form action="<?php echo site_url($search_type);?>" method="get" id="searchbox"><div class="left"><?php /*?>自定义下列框<?php */?><div class="diy_select" id="search_select"><div class="title"><a href="javascript:void(0);" id="<?php echo site_url($search_type);?>"><?php echo $search_title?></a></div><div class="option"><a href="javascript:void(0);" id="<?php echo site_url("search");?>">装修工人</a><a href="javascript:void(0);" id="<?php echo site_url("retrieval");?>">装修信息</a></div><div class="clear"></div></div>
<?php
  echo '<input type="hidden" name="search_type" id="search_type" value="" />';
  echo '<input type="hidden" name="classid" id="search_classid" value="no" />';
  echo '<input type="hidden" name="cityid" id="search_cityid" value="no" />';
  echo '<input type="hidden" name="areaid" value="no" />';
?></div><div class="right"><input name="keyword" type="text" id="keyword" value="<?php if(!empty($keyword)){echo $keyword;}?>"/></div><div class="submit"><button id="btu_search_change" class="btu_search tip" type="submit" title="我要找找!">&nbsp;</button></div><?php /*?><div class="submit"><input name="search_button" type="image" id="search_button" src="<?php echo $img_url?>search_botton.jpg" width="28" height="28" title="我要找找!" class="tip" /></div><?php */?></form>
</div></div></div></div></div></div>