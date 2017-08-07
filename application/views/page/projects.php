<?php $this->load->view('public/header'); ?><script language="javascript" type="text/javascript">
$(function(){
	//工程项目选择
	$(".page_projects_nav a").click(function(){
		var id=$(this).attr("id");
		$(this).parent().find("a").attr("class","");
		$(this).attr("class","on");
		$(".page_projects_itembox").find(".projects_item").css({"display":"none"});
		$(".page_projects_itembox").find("#item_"+id).css({"display":"block"});					 
	  });
	
	<?php if(!empty($industryid)){?>
	//初始化工种
	$(".page_projects_nav").find("a#<?php echo $industryid?>").attr("class","on");
	$(".page_projects_itembox").find(".projects_item").css({"display":"none"});
	$(".page_projects_itembox").find("#item_<?php echo $industryid?>").css({"display":"block"});
	<?php }?>
 });</script></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><div class="box" style="background-image:none;"><table width="100%" border="0" cellpadding="0" cellspacing="10" class="box tipbox" style="background-image:none; padding-left:4px;"><tr><td height="80" align="center" class="page_projects_nav">
<?php foreach($industrys as $rs){?><a href="javascript:void(0);" id="<?php echo $rs->id?>"><img src="<?php echo base_url()?><?php echo $rs->pic?>" /><br /><?php echo $rs->title?></a><?php }?></td></tr><tr><td valign="top" class="page_projects_itembox">
<?php foreach($projact as $rs){?><div class="projects_item" id="item_<?php echo $rs["p_id"];?>"><?php $cnum=0;?><?php foreach($rs["p_class"] as $crs){?><?php $cnum++;if($cnum%2==0){$class='type_item_1';}else{$class='type_item_0';}?><div class="<?php echo $class?>"><?php foreach($rs["pquery"][$crs->id] as $prs){?><div class="item" title="<?php echo $prs->title?>"><a target="_blank" href="<?php echo site_url("search")?>?industryid=<?php echo $rs["p_id"];?>&classid=<?php echo $crs->id?>&skills=<?php echo $prs->id?>&areaid=no"><?php echo $prs->title?></a></div><?php }?><div class="clear"></div></div><?php }?></div><?php }?>
&nbsp;</td></tr></table></div><!--清除浮动--><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>