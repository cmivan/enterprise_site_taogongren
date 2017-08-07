<?php $this->load->view('public/header'); ?>
<script language="javascript" type="text/javascript">
<?php /*?>初始化、绑定右边工人tab事件<?php */?>
$(function(){
$(".recommendbox .tab_top").find("a").eq(0).attr("class","on");
$(".recommendbox").find(".tab").eq(1).css({display:"block"});
});</script></head><body><?php $this->load->view('public/top');?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" id="page_h_1_1"><tr><td valign="top">
<table width="100%" border="0" align=center cellpadding=0 cellspacing=1 class="forum">
<?php if(!empty($view)){?>
<tr class="forumRow"><td height="35" align="center" style="font-size:16px; color:#333; padding-top:12px;">&nbsp;<?php echo $view->title?>&nbsp;</td></tr>
<tr class="forumRow"><td align="center" bgcolor="#FFF5E1" style="font-size:13px; border-top:#CCC 1px dotted; border-bottom:#CCC 1px dotted;padding:4px;">
时间：<?php echo $view->time?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
查看：<?php echo $view->visited?>次
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
类别：<a href="<?php echo site_url("articles/type/".$view->type_id)?>"><?php echo $view->t_title?></a></td></tr>
<tr class="forumRow"><td valign="top" class="page_view_content"><?php echo $view->content?></td></tr>

<tr class="forumRow"><td height="80" valign="top"  style=" padding:10px;border-top:#CCC 1px dotted;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;</td><td width="570">

<?php /*?>from:http://www.jiathis.com/share/<?php */?>
<!-- JiaThis Button BEGIN -->
<div id="ckepop">
	<span class="jiathis_txt">分享到：</span>
	<a class="jiathis_button_qzone">QQ空间</a>
	<a class="jiathis_button_tsina">新浪微博</a>
	<a class="jiathis_button_renren">人人网</a>
	<a class="jiathis_button_douban">豆瓣</a>
	<a class="jiathis_button_tqq">腾讯微博</a>
	<a class="jiathis_button_tieba">百度贴吧</a>
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v2.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
</td></tr></table>
</td></tr>

<?php }else{?><tr class="forumRow"><td colspan="3" align="center" bgcolor="#FFFDF7"><br />暂无记录!<br /><br /></td></tr><?php }?></table>
</td></tr></table></div></div>
<div class="index_right"><div class="right_box">
<div class="recommendbox"><div class="tab_title">学堂分类</div><div class="clear"></div><div class="tab_box" id="help_but"><div class="tab" style="display:block; background-image:url(<?php echo $img_url?>ico/num.gif);"><?php if(!empty($type)){?><?php foreach($type as $rs){?><li><dd><a href="<?php echo site_url("/articles/type/".$rs->t_id)?>"><?php echo $rs->t_title?></a></dd></li><?php }?><?php }?><div class="clear"></div></div></div><div class="clear"></div></div>

<div class="recommendbox"><div class="tab_title">热门学堂</div><div class="clear"></div><div class="tab_box" id="help_but"><div class="tab2" style="display:block; background-image:url(<?php echo $img_url?>ico/num.gif);"><?php if(!empty($list_hot)){?><?php foreach($list_hot as $rs){?><li><dd><a href="<?php echo site_url("/articles/view/".$rs->id)?>" title="<?php echo $rs->title?>"><?php echo $rs->title?></a></dd><dt><span class="red"><?php echo $rs->visited?>℃</span></dt></li><?php }?><?php }?><div class="clear"></div></div></div><div class="clear"></div></div>

<?php $this->load->view('public/mod_yxb');?>
<div class="right_ad"><a href="javascript:void(0);"><img src="<?php echo $img_url?>ads/index_ad.jpg" /></a></div> </div></div>
<!--清除浮动--><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>

