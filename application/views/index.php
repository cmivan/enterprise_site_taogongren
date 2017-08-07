<?php $this->load->view('public/header'); ?>
<?php if(1==2){?>
<link type="text/css" rel="stylesheet" href='../../public/style/main.css'/>
<link type="text/css" rel="stylesheet" href='../../public/city_select_div.css'/>
<link type="text/css" rel="stylesheet" href='../../public/js/validform/css/css.css'/>
<link type="text/css" rel="stylesheet" href='../../public/js/thickbox/thickbox.css'/>
<link type="text/css" rel="stylesheet" href='../../public/js/msg_tip/msgstyle.css'/>
<?php }?>
<style type="text/css">
#index_fabu_bu {background-image:url(<?php echo $img_url?>new_style/fabu_1.gif);background-position:center;background-repeat:no-repeat;margin-left:2px;width:250px;height:67px;cursor:pointer;}
#index_fabu_bu .index_fabu_box {padding-left:50px;padding-top:40px;}
div.on#index_fabu_bu {background-image:url(<?php echo $img_url?>new_style/fabu_2.gif);}
<?php /*?>首页正文<?php */?>
.new_main_width .skills_box {width:576px;height:567px;margin-top: 54px;margin-bottom:-31px;}
.new_main_width .hot_team {width:498px;margin:auto;height: 32px;background-image:url(<?php echo $img_url?>new_style/hot_team_bg.jpg);background-position:top;background-repeat:no-repeat;}
.new_main_width .hot_team_info {width:450px;margin-left: 80px;margin-top: 13px;}
.new_main_width .hot_team_info b {line-height:120%;}
.new_main_width .hot_team_info b a {color:#000;text-decoration:none;}
.new_main_width .hot_team_info b a:hover {text-decoration:underline;}
.new_main_width .hot_team_info .note {margin-bottom:8px;line-height:150%;color:#000;}
<?php /*?>右边<?php */?>
.new_right_box {width:254px;margin:auto;margin-top:20px;}
.new_right_box .title {width:254px;margin:auto;}
<?php /*?>最新招标<?php */?>
.new_right_box .new_zb {padding-top:6px;}
.new_right_box .new_zb div {line-height:160%;height:20px;line-height:20px;overflow:hidden;padding:0;padding-left:8px;margin:254;}
.new_right_box .new_zb div a {color:#333;text-decoration:none;}
.new_right_box .new_zb div a:hover {color:#000;text-decoration:underline;}
.new_right_box .new_zb div a.on {color:#C00;text-decoration:none;font-weight:bold;}
.new_right_box .new_zb div a.on:hover {text-decoration:underline;}
<?php /*?>热门工人<?php */?>
.new_right_box .hot_worker .item {width:42px;height:60px;text-align: center;float: left;padding-right: 10px;padding-left: 11px;padding-bottom: 5px;padding-top: 15px;overflow:hidden;}
.new_right_box .hot_worker .item a {color:#756300;text-decoration:none;}
.new_right_box .hot_worker .item a img {width:40px;height:40px;}
.new_right_box .hot_worker .item a:hover {text-decoration:underline;}
.new_right_box .hot_worker .item a:hover img {border:#F60 1px solid;}
.new_right_box .hot_worker .item .pic {width:42px;line-height: 180%;overflow:hidden;}
.new_right_box .hot_worker .item .pic img {width:40px;height:40px;border:#FC0 1px solid;}
<?php /*?>浮动层技能样式<?php */?>
.news_index_skills {padding:8px;width:258px;position:absolute;left:0;top:50px;display: none1;}
.news_index_skills .skills_items {border:#999 1px solid;margin-bottom: -1px;-moz-box-shadow: 0 4px 8px #A0522D;-webkit-box-shadow: 0 4px 8px #A0522D;box-shadow: 0 4px 8px #A0522D;position: relative;}
.news_index_skills .skills_items .box .list {border:0;z-index: 100;background:none;display:none;height:183px;}
.news_index_skills .skills_items .box .listbox {overflow: hidden;}
.news_index_skills .skills_items .box .list a {float:left;width:110px;height:23px;line-height:23px;padding-left:12px;overflow:hidden;color:#333;text-decoration:none;padding-right: 6px;background:none;}
.news_index_skills .skills_items .box .list a:hover {background-color:#F90;color:#FFF;}
.news_index_skills .skills_items .box .select {padding:12px;z-index:20;height: 20px;}
.news_index_skills .skills_items .box .select .more {text-align:center;position:absolute;z-index: 50;top:auto;right:12px;}
.news_index_skills .skills_items .box .selclass {height:18px;line-height:18px;background-image:url(<?php echo $img_url?>new_style/class_line.jpg);background-position:left;background-repeat:no-repeat;position: absolute;z-index: 50;margin-right:-1px;}
.news_index_skills .skills_items .box .selclass a {float:left;width:40px;text-align: center;text-decoration:none;margin-right: 1px;color:#000;}
.news_index_skills .skills_items .box .selclass a:hover {background-color:#F90;color:#FFF;}
.news_index_skills .skills_items .box .selclass a.on {background-color:#F90;color:#FFF;}
.news_index_skills .skills_items .skills_bg {position: absolute;filter:alpha(opacity=95);opacity:0.95;-moz-opacity:0.95;background-image:url(<?php echo $img_url?>new_style/index_skills_bg2.jpg);background-position:left top;left:0;right:0;bottom: 0;top: 0;z-index:1;}
.news_index_skills .skills_items .box .skills_bottom {background-color:#FFF;position: absolute;filter:alpha(opacity=80);opacity:0.8;-moz-opacity:0.8;left:0;right:0;bottom: 0;top: 0;z-index:0;}
<?php /*?>底部<?php */?>
.copyright {padding-left:68px;padding-right: 340px;padding-top: 33px;height: 48px;overflow: hidden;}
.copyright .main_width {width:948px;margin:auto;}
.copyright a {color:#000;text-decoration:none;}
.copyright a:hover {color:#000;text-decoration:underline;}
.copyright .copyright_line {background-image:url(<?php echo $img_url?>new_style/new_line.jpg);background-position:top;background-repeat:repeat-x;height:8px;line-height:8px;margin:auto;margin-left: 3px;margin-right: 3px;display:block;}
.copyright .new_copyright {padding-left:68px;padding-right: 340px;padding-top: 33px;height: 48px;overflow: hidden;}
.body_bottom {height:96px;background-image:url(<?php echo $img_url?>new_style/bottom.jpg);background-position:top;background-repeat:no-repeat;background-color:#000;margin-bottom: 12px;text-align:center;line-height:160%;color:#333;}
.body_bottom a {color:#000;text-decoration:none;}
.body_bottom a:hover {color:#000;text-decoration:underline;}

#ad_box_group{padding:5px;padding-top:15px;padding-left:42px;}
#ad_box_group li.ad_box{ float:left; width:118px; height:48px; overflow:hidden; border:#ddbe0a 1px solid; margin-right:3px; text-align:center; padding:1px; }
</style>
</head><body>
<?php $this->load->view('public/top'); ?>
<?php /*?>首页左边尖角<?php */?>
<div style="position:relative;z-index:99" class="new_main_width">
<div style="position:absolute;width:46px;height:40px;top:-32px;background-image:url(<?php echo $img_url?>new_style/top_left_jian.jpg);z-index:999">&nbsp;</div>
</div>
<div class="new_main_width new_content_skill">
<?php
//读取工种
$skillItem=0;
foreach($projact as $rs){
?>
<div class="news_index_skills" id="skill_i_<?php echo $skillItem?>">
<div class="skills_items"><div class="box"><div class="listbox">
<?php foreach($rs["p_class"] as $crs){?>
<div class="list">
<?php foreach($rs["pquery"][$crs->id] as $prs){?>
<a target="_blank" href="<?php echo site_url("search/")?>?industryid=<?php echo $rs["p_id"];?>&classid=<?php echo $crs->id?>&skills=<?php echo $prs->id?>"><?php echo $prs->title?></a>
<?php }?>
<div class="clear"></div></div>
<?php }?>
<div class="skills_bg bg" style="width:258px; height:185px;">&nbsp;</div></div>
<div class="listbox"><div class="select"><div class="selclass">
<?php foreach($rs["p_class"] as $crs){?><a href="javascript:void(0);" class="on"><?php echo $crs->title?></a><?php }?>
</div>
<div class="more"><a target="_blank" href="<?php echo site_url("page/projects/".$rs["p_id"])?>" title="更多<?php echo $rs["p_title"]?>项目"><img src="<?php echo $img_url?>new_style/more.gif" width="35" height="18" /></a></div>
</div>
<div class="skills_bottom bg" style="width:258px;height:44px;">&nbsp;</div>
</div></div></div>
</div> <?php $skillItem++; } ?>
</div>
<div class="new_main_width new_main_bg">
<div class="new_left"><img src="<?php echo $img_url?>new_style/index_02.jpg" width="48" height="828" alt="" /></div>
<div class="new_content">
<?php /*?>活动ad<?php */?>
<div style="position:relative">
<div style="position:absolute; width:575px; height:28px; line-height:28px; padding-top:1px; padding-bottom:3px; background-color:#000; overflow:hidden; left: 2px; top: 1px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td width="44" align="left"><img src="<?php echo $img_url?>new_style/index_ad_ico.gif" width="44" height="32" /></td>
<td style="padding-left:5px; font-size:13px; font-weight:bold;"><a href="<?php echo site_url("reg")?>" target="_blank" style="color:#ffd900;">无论你是业主，还是工人，网站试运行期间，登录注册并完善资料，<span style="color:#F00">即送10元！</span></a></td><td width="10">&nbsp;</td></tr></table>
</div></div>
<div class="skills_box"><img src="<?php echo $img_url?>new_style/index_skills_bg.jpg" alt="" width="576" height="567" border="0" usemap="#Map" />
<map name="Map" id="Map">
<area shape="poly" id="0" coords="440,446,490,474,539,446,539,388,490,359,440,388" href="javascript:void(0);" />
<area shape="poly" id="5" coords="340,446,387,473,433,446,433,391,388,364,340,391" href="javascript:void(0);" />
<area shape="poly" id="8" coords="288,359,336,386,385,356,385,302,336,274,288,302" href="javascript:void(0);" />
<area shape="poly" id="2" coords="186,358,234,386,282,358,282,302,234,274,186,302" href="javascript:void(0);" />
<area shape="poly" id="4" coords="85,357,134,384,180,357,180,303,132,275,85,303" href="javascript:void(0);" />
<area shape="poly" id="6" coords="342,270,390,297,437,269,437,214,389,187,342,214" href="javascript:void(0);" />
<area shape="poly" id="9" coords="133,269,182,297,231,269,231,213,182,185,133,213" href="javascript:void(0);" />
<area shape="poly" id="7" coords="31,270,80,298,129,270,129,214,79,186,31,214" href="javascript:void(0);" />
<area shape="poly" id="3" coords="289,183,335,210,384,182,384,125,335,96,289,123" href="javascript:void(0);" />
<area shape="poly" id="1" coords="185,179,234,207,281,180,281,125,234,97,185,125" href="javascript:void(0);" />
<area shape="poly" coords="435,92,485,121,534,92,534,34,485,6,435,34" href="<?php echo site_url('page/projects');?>" title="查看所有工种项目!" />
</map>
</div>
<?php /*?>广告位<?php */?>
<div id="ad_box_10" class="ad_box" style="padding:5px;padding-left:42px;"></div>
<div class="hot_team"><img src="<?php echo $img_url?>new_style/hot_team_bg.jpg" width="498" height="32" /></div>
<div class="hot_team_info">
<?php
foreach($hot_team as $rs){
$uid = $rs->tid;
if($uid==0) $uid = $rs->$uid;
?>
<b><a href="<?php echo site_url("user/".$uid)?>" title="<?php echo $rs->title?>"><?php echo cutstr($rs->title,16)?></a></b><br />
<div class="note"><?php echo $rs->ad?></div>
<?php }?>
</div>

<?php /*?>广告位<?php */?>
<div id="ad_box_group">
<li id="ad_box_6" class="ad_box"></li><li id="ad_box_7" class="ad_box"></li><li id="ad_box_8" class="ad_box"></li><li id="ad_box_9" class="ad_box"></li>
</div></div>

<div class="new_right_0"><img src="<?php echo $img_url?>new_style/index_05.jpg" width="9" height="828" alt="" /></div>
<div class="new_right">
<div class="new_right_box">
<div id="index_fabu_bu">
<div class="index_fabu_box"> <a <?php echo $tb_but?>>工程投标</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a <?php echo $zp_but?>>招聘工人</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a <?php echo $qz_but?>>我要求职</a> </div>
</div></div>

<?php /*?>广告位<?php */?>
<div class="new_right_box"><div id="ad_box_3" class="ad_box"></div></div>
<div class="new_right_box">
<div class="title"><img src="<?php echo $img_url?>new_style/left_title_03.jpg" width="254" height="56" /></div>
<div class="new_zb">
<?php
$i = 0;
foreach($zb_ad as $rs){ $i++; ?>
<div><a<?php if($i<=2){echo ' class="on"';}?> target="_blank" href="<?php echo site_url("retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?> (预算<?php echo $rs->cost?>元)">
<?php echo cutstr($rs->title,20)?></a></div><?php };?>
</div></div>


<?php /*?>广告位<?php */?>
<div class="new_right_box"><div id="ad_box_4" class="ad_box"></div></div>

<div class="new_right_box">
<div class="title"><img src="<?php echo $img_url?>new_style/left_title_05.jpg" width="254" height="54" /></div>
<div class="hot_worker">
<?php foreach($hot_company as $rs){?>
<div class="item"><div class="pic"><a href="<?php echo site_url("user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" /><br /><?php echo $rs->name?></a></div></div><?php }?>
<div class="clear"></div>
</div></div>


<?php if(!empty($index_case)){?>
<div class="new_right_box">
<div id="index_cases">

<!--newsSlider start -->
<LINK href="<?php echo $js_url?>loopedslider/case.css" type=text/css rel=stylesheet>
<SCRIPT src="<?php echo $js_url?>loopedslider/loopedslider.min.js" type=text/javascript></SCRIPT>
<DIV id=newsSlider>
<DIV class=container>
<UL class=slides>

<?php
$casenum = 0;
foreach($index_case as $item){
	$casenum++; ?>
<LI><A href="<?php echo site_url('user/'.$item->uid)?>" target="_blank"><IMG width="248" height="178" src="<?php echo img_cases($this,$item->pic)?>"></A>
<DL>
<DT><A href="<?php echo site_url('user/'.$item->uid)?>" target="_blank"><?php echo cutstr($item->title,20)?></A></DT>
<?php /*?><DD><?php echo cutstr($item->content,100)?></DD><?php */?>
</DL>
</LI>
<?php }?>

</UL>
</DIV>

<DIV class=validate_Slider></DIV>
<UL class=pagination>
<?php for($i=1;$i<=$casenum;$i++){?>
  <LI><A href="javascript:void(0);"><?php echo $i?></A></LI>
<?php }?>
</UL>

</DIV>

<SCRIPT type=text/javascript>
$(function(){
	$('#newsSlider').loopedSlider({ autoStart: 3000 });
	$('.validate_Slider').loopedSlider({ autoStart: 3000 });
	$("#enter_lab").click(function(){
	window.location = $(this).find("a").attr("href"); return false;});
});
</SCRIPT>
    
</div>
</div>
<?php }?>

<?php /*?>广告位<?php */?>
<div class="new_right_box"><div id="ad_box_4" class="ad_box"></div></div>

<div class="new_right_box">
<div class="title"><img src="<?php echo $img_url?>new_style/left_title_06.jpg" width="254" height="54" /></div>
<div class="hot_worker">
<?php foreach($hot_workers as $rs){?>
<div class="item"><div class="pic"><a href="<?php echo site_url("user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" /><br /><?php echo $rs->name?></a></div></div><?php }?>
<div class="clear"></div>
</div></div>

<?php /*?>广告位<?php */?>
<div class="new_right_box"><div id="ad_box_5" class="ad_box"></div></div>

<div class="new_right_box">
<div class="title"><img src="<?php echo $img_url?>new_style/left_title_08.jpg" width="254" height="56" /></div>
<div class="hot_worker">
<?php foreach($hot_design as $rs){?>
<div class="item"><div class="pic"><a href="<?php echo site_url("user/".$rs->id)?>"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" /><br /><?php echo $rs->name?></a></div></div>
<?php }?>
<div class="clear"></div>
</div></div>

</div>
<div class="clear"></div>
</div>
<?php /*?>广告位<?php */?>
<div id="ad_box_1" class="ad_box" style="position:absolute; right:0px; top:25px; text-align:right;width:auto; height:auto; z-index:99"></div>
<?php /*?><div id="ad_box_1" class="ad_box" style="z-index:998;"></div><?php */?>
<?php /*?>右边浮动广告<?php */?>
<div id="ad_box_2" class="ad_box" style="z-index:999">
<div id="ad_close" style="text-align:right"><a href="javascript:void(0);"> <img style="border:#555 1px solid; margin:1px;" src="<?php echo $js_url?>thickbox/images/close.gif" height="11" width="11" /></a> </div>
</div>

<?php /*?>广告Js<?php */?>
<script language="javascript" src="<?php echo site_url('ads')?>?id=1"></script>
<script type="text/javascript">
$(function(){
<?php /*?>$("#ad_box_1").jFloat({position:"right",top:27,height:100,width:100,left:0});<?php */?>
$("#ad_box_2").jFloat({position:"left",top:230,width:142,left:0});
$("#ad_box_2").css({'display':'none'});
$("#ad_close a").live('click',function(){ $("#ad_box_2").fadeOut(200); });
});</script>

<?php $this->load->view('public/footer'); ?>
