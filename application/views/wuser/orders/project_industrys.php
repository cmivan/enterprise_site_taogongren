<?php if(!empty($Irs)){ ?><script language="javascript" type="text/javascript" src="<?php echo $jq_url;?>"></script><script type="text/javascript">
$(function(){
   <?php /*?>//--返回参数并调用计算总费--<?php */?>
   var pobj = window.parent.parent.document;
   $(pobj).find("#project").val($("#project").text());
   $(pobj).find("#num").val("1");
   $(pobj).find("#units").val($("#units").text());
   $(pobj).find("#r_price").val($("#r_price").text());
   $(pobj).find("#c_price").val($("#c_price").text());
   $(pobj).find("#p_note").val($("#p_note").html());
   window.parent.parent.allprice();
   window.parent.parent.Tbox_close();
   });</script><p id="project"><?php echo $Irs->title?></p><p id="units"><?php echo $Irs->units?></p><p id="r_price"><?php echo $Irs->r_price?></p><p id="c_price"><?php echo $Irs->c_price?></p><p id="p_note"><?php echo $Irs->note?></p><?php exit;}?>

<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>page_user_skills.css" />
<script type="text/javascript"><?php /*?>初始化位置<?php */?>
$(function(){<?php /*?>绑定Tabl<?php */?>
  $(".industry_item_box").find("div.item_box").css({"display":"none"});
  $(".industry_item_box").find("div.item_box").eq(0).css({"display":"block"});
  $(".industry_item").find("li").eq(0).attr("class","over");
  $(".industry_item").find("li").click(function(){
		  var itemid=$(this).attr("itemid");
		  $(".industry_item_box").find("div.item_box").css({"display":"none"});
		  $(".industry_item_box").find("div#"+itemid).css({"display":"block"});
		  $(".industry_item").find("li").attr("class","");
		  $(this).attr("class","over");
  });<?php /*?>提交选择操作<?php */?>
  $(".item_box").find("div a").click(function(){$(this).fadeOut(100).fadeIn(300);return true;});
  });
function Ok(){window.parent.location.reload();}</script><div class="industry_box" style="border-bottom:0; border-left:0; border-right:0;"><div class="industry_item"><?php
//读取工种
$jobs_query=mysql_query("select * from industry where industryid=0 order by orderid asc");
while($row=mysql_fetch_array($jobs_query)){   
?><li itemid="<?php echo $row["id"]?>"><a href="javascript:void(0);"><?php echo $row["title"]?></a></li><?php }?><div class="clear"></div></div>
<div class="industry_item_box" style="border:0;padding:0px;"><?php
//读取工种
$jobs_query=mysql_query("select * from industry where industryid=0 order by orderid asc");
while($jobs_row = mysql_fetch_array($jobs_query)){   
?><div class="item_box" id="<?php echo $jobs_row["id"]?>">
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab_item" style="background-color:#FC6;"><?php
//读取分类
$class_query=mysql_query("select * from industry_class order by id asc");
while($class_row = mysql_fetch_array($class_query)){
//判断该类型的工种是否已经录入具体项目
$c_r_query=mysql_query("select count(id) from industry where industryid=".$jobs_row["id"]." and classid=".$class_row["id"]);
$c_r_row  =mysql_fetch_array($c_r_query);
//获取到具体项目
if($c_r_row[0]>0){
?><tr><td width="6%" height="28" align="center" bgcolor="#FFFFFF" class="class_title"><?php echo $class_row["title"]?></td><td width="94%" bgcolor="#FFFFFF"><?php
//读取项目
$pro_sql  = "select * from industry where industryid=".$jobs_row["id"]." and classid=".$class_row["id"]." order by title asc";
$pro_query=mysql_query($pro_sql);
while($pro_row = mysql_fetch_array($pro_query)){
?><div><a href="<?php echo site_url($c_urls.'/project_industrys')?>?industryid=<?php echo $pro_row["id"]?>" target="industrys"><?php echo $pro_row["title"]?></a></div><?php }?></td></tr><?php	}}?>  </table></div><?php }?></div></div><iframe name="industrys" style="width:1px;height:1px; visibility:hidden" frameborder="0" scrolling="no"></iframe>