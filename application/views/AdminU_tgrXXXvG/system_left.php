<?php
//-=================================================-
//-====  |       伊凡php建站系统 v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-04-02 11:00    | ====-
//-====  |       For    : 齐翔广告             | ====-
//-=================================================-
?>
<?php $this->load->view_system('header'); ?>

<script language="javascript">
$(function(){
	$(".menu").find("dl").find("dt").find("a").click(function(){
		$(this).parent().parent().parent().find("dd").css({"display":"none"});
		$(this).parent().parent().find("dd").css({"display":"block"});});
	$(".menu").find("dl").eq(0).find("dd").css({"display":"block"});
});
</script>

<base target="km_main">
</head>
<BODY id="meun_body">
<div class="menu">

<dl><dt><a href="javascript:void(0);">网站信息</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'system_user')?>">管理员管理</a></li>
<li><a href="<?php echo site_url($s_urls.'/system_onekey')?>">创建一键登录</a></li>
<li><a href="<?php echo site_url($s_urls.'/system_info')?>">网站信息配置</a></li>
<li><a href="<?php echo site_url('ver/urlto');?>?url=/index" target="_blank">预览网站</a></li>
<li><a href="javascript:void(0);" class="login_out" url="<?php echo site_url($s_urls)?>?login=out" target="_top">退出管理</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">用户管理</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'user_info/edit')?>">录入工人</a></li>
<li><a href="<?php echo site_url($s_url.'user_info')?>">管理工人</a></li>
<li><a class="left_nav_line"></a></li>
<li><a href="<?php echo site_url($s_url.'user_company_info/edit')?>">创建企业用户</a></li>
<li><a href="<?php echo site_url($s_url.'user_company_info')?>">管理企业用户</a></li>
<?php /*?>
<li><a style="height:0px; line-height:0px; background-color:#999;"></a></li>
<li><a href="<?php echo site_url($s_url.'user_info')?>">录入业主</a></li>
<li><a href="<?php echo site_url($s_url.'user_info')?>">管理业主</a></li>
<?php */?>
</ul></dd>
</dl>

<dl><dt><a href="javascript:void(0);">广告管理</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'sys_ads')?>">广告管理</a></li>
<li><a href="<?php echo site_url($s_url.'sys_ads/ad_set')?>">位置管理</a></li>
<li><a href="<?php echo site_url($s_url.'sys_ads/ad_page')?>">投放页面</a></li>
</ul></dd>
</dl>

<dl><dt><a href="javascript:void(0);">用户操作</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'user_approve')?>">身份认证</a></li>
<li><a href="<?php echo site_url($s_url.'user_feedback')?>">留言反馈</a></li>
<li><a href="<?php echo site_url($s_url.'user_introduce')?>">介绍好友</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">装修学堂</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'page_articles')?>">管理装修学堂</a></li>
<li><a href="<?php echo site_url($s_url.'page_articles/edit')?>">添加装修学堂</a></li>
<li><a href="<?php echo site_url($s_url.'page_articles/type')?>">装修学堂分类</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">工会信息</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'page_unions')?>">管理工会信息</a></li>
<li><a href="<?php echo site_url($s_url.'page_unions/edit')?>">添加工会信息</a></li>
<li><a href="<?php echo site_url($s_url.'page_unions/type')?>">工会信息分类</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">地区管理</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'place_province')?>">地区管理</a></li>
<li><a href="<?php echo site_url($s_url.'place_province/province_edit')?>">添加省份</a></li>
<li><a href="<?php echo site_url($s_url.'place_city/city_edit')?>">添加城市</a></li>
<li><a href="<?php echo site_url($s_url.'place_area/area_edit')?>">添加地区</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">投标信息</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'user_retrieval')?>">信息管理</a></li>
</ul></dd>
</dl>


<dl><dt><a href="javascript:void(0);">项目分类</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'sys_industry/industry_manage')?>">管理项目</a></li>
<li><a href="<?php echo site_url($s_url.'sys_industry/industry_edit')?>">添加项目</a></li>
<li><a class="left_nav_line"></a></li>
<li><a href="<?php echo site_url($s_url.'sys_industry/industrys_manage')?>">管理工种</a></li>
<li><a href="<?php echo site_url($s_url.'sys_industry/industrys_edit')?>">添加项目</a></li>
</ul></dd>
</dl>


<dl style="display:none;"><dt><a href="javascript:void(0);">其他页面</a></dt>
<dd><ul>
<li><a href="<?php echo site_url($s_url.'page_other')?>">管理页面</a></li>
<li><a href="<?php echo site_url($s_url.'page_other/edit')?>">添加页面</a></li>
</ul></dd>
</dl>

</div>

</BODY>
</HTML>
