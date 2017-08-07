<?php $this->load->view('public/header'); ?>
<?php /*?>技能列表<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>page_user_skills.css" />
<?php /*?>点击技能时响应<?php */?>
<script language="javascript" type="text/javascript"> 
$(function(){
$(".pro_item a").click(function(){
	var pro_id=$(this).parent().attr("id");
	tb_show('添加技能报价','<?php echo site_url($c_urls."/edit")?>?height=175&width=420&pro_id='+pro_id,false);
});});
</script>
</head><body>
<?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box">
<div class="content tipbox">温馨提示：您可以点击下面的项目，并填写您对该项目的报价!</div>
<br>
<div class="content">
<?php
//读取当前用户技能
if(!empty($skills_count)&&$skills_count>0){?>

<div class="industry_box">
<span style="font-weight:bold; padding-left:3px;">
擅长工种：
<?php
//读取用户工种
if(!empty($goodat_industrys)){
   $jobsNum=0;
   foreach($goodat_industrys as $gi_rs){
	   $jobsNum++;
	   if($jobsNum>1){echo "、";}
	   echo "<span>".$gi_rs->title."</span>";
	   }
}
?></span>


<div class="clear"></div>
<div class="clear" style="margin-top:5px;">
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab_item" style="border-top:#FC0 2px solid;">
<?php
//读取分类
if(!empty($goodat_classes)){
  foreach($goodat_classes as $gc_rs){
?><tr class="edit_item_tr"><td width="6%" height="28" align="center" class="class_title"><?php echo $gc_rs->title?></td><td width="94%" style="padding:8px;">
<?php
//读取用户工种
$gc_industrys=$this->Industry_Model->goodat_class_industrys($gc_rs->id,$logid);

if(!empty($gc_industrys)){
  $jobsNum=0;
  foreach($gc_industrys as $gci_rs){
	$jobsNum++;
	if($jobsNum>1){echo "<div class='hr'>&nbsp;</div>";}
	//读取项目
	$gci_skills=$this->Industry_Model->goodat_class_industry_skills($gc_rs->id,$gci_rs->id,$logid);
	
	if(!empty($gci_skills)){
		foreach($gci_skills as $gcis_rs){
			$pro_tip="";
			$pro_css="";
			if(is_numeric($gcis_rs->price)&&$gcis_rs->price!=0&&$gcis_rs->note!=""){
				$pro_tip="，报价:".$gcis_rs->price."(元)";
				$pro_css=" style='color:#F00;text-decoration:underline'  class='tip'";
				}
?><div class="pro_item" id="<?php echo $gcis_rs->id?>"><a href="javascript:void(0);" title="<?php echo $gcis_rs->title.$pro_tip?>" <?php echo $pro_css?>><?php echo $gcis_rs->title?></a></div>
<?php }}}}?></td></tr><?php }?></table></div></div>

<?php }}else{?>
<div class="industry_box cm_btu">
<br /><br /><br />
<table border="0" align="center">
<tr><td><a class="buttom" href="<?php echo site_url($c_urls."/skills_management")?>">+请添加技能+</a></td></tr>
</table><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>
<?php }?>
</div></div></div></div>
<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>