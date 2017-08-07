<?php /*?>页面顶部<?php */?>
<div class="main_top_muen">
<div class="main_width">
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
<div id="userloginbox"></div>
</td><td align="right" id="top_nav_right"><li><a href="<?php echo site_url("articles")?>" class="new_ico">装修学堂<span><b>news</b></span></a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="favorite">收藏本站</a></li><li class="line">&nbsp;</li><li><a href="<?php echo site_url("page/help")?>">帮助中心</a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="contact">联系我们</a></li><li class="line">&nbsp;</li><li><a href="javascript:void(0);" class="user_feedback">意见反馈</a></li></td>
</tr></table>
</div></div>

<?php /*?>顶部主体<?php */?>
<div class="new_top new_main_width">
<div class="top_box">
<div class="top_city">
<?php /*?>城市切换框<?php */?>
<div class="city_select">
<div class="citys" style="margin-bottom:0;"><div id="title" class="off tip"  title="点击切换城市！" >
<?php
$city = $this->Place_Model->city();
if(!empty($city)){?><a href="javascript:void(0);" id="<?php echo $city->c_id;?>"><?php echo $city->c_name;?></a><?php }?>
</div>
<div class="clear"></div></div>
<?php /*?>切换下拉框<?php */?>
<div class="provinces_citys_box">
<div class="provinces_citys">
<div class="quyu">
<?php
$r_id = $this->Place_Model->r_id;
$regions = $this->Place_Model->regions();
if(!empty($regions))
{
	foreach($regions as $rs){
		echo '<a href="javascript:void(0);" id="' . $rs->r_id . '"';
		if($rs->r_id==$r_id) echo ' class=on';
		echo '>' . $rs->r_name . '</a>';
	}
}
?>
<div class="clear"></div>
</div>

<div id="quyu_box"></div>
<script> $(function(){ $('#quyu_box').load('<?php echo site_url('places/sel_provinces');?>?r_id=<?php echo $r_id?>'); }); </script>

</div></div>
</div></div>
    
<div class="top_nav_search">
<?php /*?>导航栏目<?php */?>
<div class="top_nav"><a class="nav_1" href="<?php echo site_url("index")?>">淘首页</a><a class="nav_2" href="<?php echo site_url("search")?>">淘工人</a><a class="nav_3" href="<?php echo site_url("info")?>">淘信息</a><a href="http://mall.taogongren.com" target="_blank" class="nav_4">淘材料</a><a class="nav_5" href="<?php echo site_url("unions")?>">淘工会</a></div>

<?php /*?>搜索栏目<?php */?>
<div class="top_search"><div class="seach">
<div class="seach_box">
<form action="<?php echo site_url($search_type);?>" method="get" id="searchbox"><div class="left"><?php /*?>自定义下列框<?php */?><div class="diy_select" id="search_select"><div class="title"><a href="javascript:void(0);" id="<?php echo site_url($search_type);?>"><?php echo $search_title?></a></div><div class="option"><a href="javascript:void(0);" id="<?php echo site_url("search");?>">装修工人</a><a href="javascript:void(0);" id="<?php echo site_url("retrieval");?>">装修信息</a></div><div class="clear"></div></div>
<?php
  echo '<input type="hidden" name="search_type" id="search_type" value="" />';
  echo '<input type="hidden" name="classid" id="search_classid" value="no" />';
  echo '<input type="hidden" name="c_id" id="search_c_id" value="no" />';
  echo '<input type="hidden" name="a_id" value="no" />';
?>
</div>
<div class="right">
<input x-webkit-speech name="keyword" type="text" id="keyword" value="<?php if(!empty($keyword)){echo $keyword;}?>"/></div>
<div class="submit">
<?php
//设置搜索按钮的显示状态
$css_zoom = 'block';
$css_eraser = 'none';
if(!empty($keyword))
{
	$css_zoom = 'none';
	$css_eraser = 'block" cmd="y';
}
?>
<button style="display:<?php echo $css_zoom?>" id="btu_search_change" class="btu_search tip" type="submit" title="我要找找!">&nbsp;</button>
<a style="display:<?php echo $css_eraser?>" href="?keyword=" id="eraser"><img src="<?php echo base_url()?>public/images/ico/search_botton_eraser.gif" width="28" height="28" id="search_botton_eraser" title="清除关键词，重新输入!" class="tip" /></a>
</div>
</form></div></div></div></div></div></div>