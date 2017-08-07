<?php /*?>技能列表<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>page_user_skills.css" />
<script type="text/javascript"><?php /*?>初始化位置<?php */?>
$(function(){
  <?php /*?>绑定Tabl<?php */?>
  $(".industry_item_box").find("div.item_box").css({"display":"none"});
  $(".industry_item_box").find("div.item_box").eq(0).css({"display":"block"});
  $(".industry_item").find("li").eq(0).attr("class","over");
  $(".industry_item").find("li").click(
		function(){
			var itemid=$(this).attr("itemid");
			$(".industry_item_box").find("div.item_box").css({"display":"none"});
			$(".industry_item_box").find("div#"+itemid).css({"display":"block"});
			$(".industry_item").find("li").attr("class","");
			$(this).attr("class","over");
			});
  
  <?php /*?>多所有多选框解冻<?php */?>
  $(".item_box").find("input[type='checkbox']").attr("disabled",false);
  <?php /*?>  $(".item_box").find("input[type='checkbox']").attr("disabled",false);
  提交选择操作<?php */?>
  $(".item_title").find("input[type='checkbox']").click(
		function(){
			var industryid=$(this).attr("id");
			var thischecked=$(this).attr("checked");
			if(thischecked){checked="1";}else{checked="0";}
			<?php /*?>临时<?php */?>
			var title=$(this);
			$.ajax({
				   type:'GET',
				   url:"<?php echo site_url($c_urls."/checked_one")?>?checked="+checked+"&industryid="+industryid,
				   success:function(data){ if(data=="1"){return true;}else{return false;} }
				   });
			   });
  
  <?php /*?>全选对应的工种<?php */?>
  $(".class_title").find("input[type='checkbox']").click(function(){
	   <?php /*?>锁定全选按钮<?php */?>
	   $(this).attr("disabled",true);
	   var classid=$(this).val();
	   var industryid=$(this).attr("industryid");
	   var thischecked=$(this).attr("checked");
	   var allInput=$(this).parent().parent().parent().find("input");
	   if(thischecked){checked="1";}else{checked="0";}
	   $.ajax({
			   type:'GET',
			   url:"<?php echo site_url($c_urls."/checked_all")?>?checked="+checked+"&classid="+classid+"&industryid="+industryid,
			   success:function(data){
				   if(data=="0"){allInput.attr("checked",false);}else{allInput.attr("checked",true);}
				   }});
		
		<?php /*?>打开全选按钮<?php */?>
		$(this).attr("disabled",false); 
	});
  
  <?php /*?>用于加载完成后，判断对应的项目是否全部被选中<?php */?>
  $(".class_title").find("input").each(function(){
		  var thisClass=$(this);
		  $(this).parent().parent().parent().find("input").each(function(){
			   thisClass.attr("checked",true);
			   if($(this).attr("checked")==false){thisClass.attr("checked",false);}
			});
		   });
  });
</script>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box" style="padding-left:0; padding-right:0; padding-bottom:0; border-bottom:0; border-left:0; border-right:0;"><div class="thistip"></div>
<?php
$rsarrid="|0|"; //初始化
if(!empty($goodat_skills))
{
	foreach($goodat_skills as $goodat_skillsItem)
	{
		$rsarrid = $rsarrid . $goodat_skillsItem->industryid . '|';
	}
}
?>
<div class="industry_box" style="border-bottom:0; border-left:0; border-right:0;">
<div class="industry_item">
<?php
//读取工种
if(!empty($industrys))
{
	foreach($industrys as $industrysItem)
	{
?>
<li itemid="<?php echo $industrysItem->id?>"><a href="javascript:void(0);" cmd='null'><?php echo $industrysItem->title?></a></li>
<?php 	}}?>

<div class="clear"></div></div>
<div class="industry_item_box" style="border:0;padding:0px;">
<?php
//读取工种
if(!empty($industrys))
{
	foreach($industrys as $industrysItem)
	{
?>
<div class="item_box" id="<?php echo $industrysItem->id?>">
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab_item">
<?php
//读取分类
if(!empty($industry_class))
{
	foreach($industry_class as $Iclass_item)
	{
		$class_industrys = $this->Industry_Model->class_industrys( $Iclass_item->id , $industrysItem->id );
		//返回某种类某分类下的技能
		if( !empty($class_industrys) ){
?>
<tr class="edit_item_tr">
<td width="6%" height="28" align="center" class="class_title">
<label><input disabled="disabled" title="点击全选对应的<?php echo $Iclass_item->title?>项目" type="checkbox" value="<?php echo $Iclass_item->id?>" industryid="<?php echo $industrysItem->id?>" />
<br /><?php echo $Iclass_item->title?></label>
</td>
<td width="94%" class="item_title">
<?php
//读取项目
	foreach($class_industrys as $pro_row)
	{
		$pro_ids = '|' . $pro_row->id . '|';
?>
<div><label><input disabled="disabled" id="<?php echo $pro_row->id?>" title="<?php echo $pro_row->title?>" type="checkbox" value="1" <?php if(strpos($rsarrid,$pro_ids)>0){?>checked="checked"<?php }?> /><?php echo $pro_row->title?></label></div>
<?php }?>
</td></tr>
<?php	}}}?>
</table></div>
<?php }}?>

</div></div></div></div>