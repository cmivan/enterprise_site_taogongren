<?php include("api/conn.db.php");?>
<?php
/*判断是否已经登录*/
   user_logined(0);
/*获取工人信息*/
   $uid=$_SESSION["tg_w_id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>行业分类</title>
<link rel="stylesheet" type="text/css" href="views/css/page-reg.css" />
<script type="text/javascript" src="views/js/jquery-1.4.pack.js"></script>
<script type="text/javascript">
//初始化位置
$(function(){
  //绑定Tabl
  $(".industry_item_box").find("div.item_box").css({"display":"none"});
  $(".industry_item_box").find("div.item_box").eq(0).css({"display":"block"});
  $(".industry_item").find("li").eq(0).attr("class","over");
  
  $(".industry_item").find("li").click(
									   function(){
										   var itemid=$(this).attr("itemid");
										   $(".industry_item_box").find("div.item_box").css({"display":"none"});
										   $(".industry_item_box").find("div#"+itemid).css({"display":"block"});
										   //
										   $(".industry_item").find("li").attr("class","");
										   $(this).attr("class","over");
										   }
				);
  
  
  $(".item_box").find("input[type:checkbox]").attr("disabled",false);
  //提交选择操作
  $(".item_box").find("input[type:checkbox]").click(
									   function(){
										   isok(0);
										   var industryid=$(this).attr("id");
										   var checked=$(this).attr("checked");
										   if(checked){checked="1";}else{checked="0";}
										   //临时
										   var title=$(this);
										   
										   $.ajax({
												  type:'GET',
												  url:"api/reg/action.php?action=checked&industryid="+industryid+"&checked="+checked+"&t="+Math.random(),
												  success:function(da){
													  //临时
													  if(da=="ok"){return true;}else{return false;}
													  }
												  });
										   isok(1);
										   });
  
  
  //全选对应的工种
  $(".class_title").find("input").click(function(){
	   isok(0);
	   $(this).attr("disabled",true); //锁定全选按钮					 
		var thischecked=$(this).attr("checked");
		var allInput=$(this).parent().parent().parent().find("input");
		if(thischecked){
		   allInput.each(function(){
		     var thisInput =$(this);													  
		     var industryid=$(this).attr("id");
		   $.ajax({
				  type:'GET',
				  url:"api/reg/action.php?action=checked&industryid="+industryid+"&checked=1&t="+Math.random(),
				  success:function(){
					  thisInput.attr("checked",true);
					  }
				  });
			});

		}else{
		   allInput.each(function(){
		     var thisInput =$(this);													  
		     var industryid=$(this).attr("id");
		   $.ajax({
				  type:'GET',
				  url:"api/reg/action.php?action=checked&industryid="+industryid+"&checked=0&t="+Math.random(),
				  success:function(){
					  thisInput.attr("checked",false);
					  }
				  });
		   });
		}
		isok(1);
		$(this).attr("disabled",false); //打开全选按钮	
	});
  
  
  //用于加载完成后，判断对应的项目是否全部被选中
  $(".class_title").find("input").each(function(){
		  var thisClass=$(this);
		  $(this).parent().parent().parent().find("input").each(function(){
			   thisClass.attr("checked",true);
			   if($(this).attr("checked")==false){thisClass.attr("checked",false);}
			});
		   });


  
  
  
  });


//用于控制确定按钮
function isok(ok){
	var okObj=$(window.parent.document).find("#jd_submit");
	if(ok==0){
	   okObj.attr("disabled",true);
	   okObj.val(" 操作中... ");
	}else{
	   okObj.attr("disabled",false);
	   okObj.val(" 确定 ");	
	}
}
</script>

<script>
function Ok(){
	window.parent.location.reload();
	}
</script>


<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<body>
<?php
$rsarrid="|0|"; //初始化
$db->query("select industryid from skills where workerid=$uid order by id asc");
while($row = $db->fetch_array($rs)){
	  $rsarrid=$rsarrid.$row["industryid"]."|";
	}
?>
<div class="industry_box" style="border-bottom:0; border-left:0; border-right:0;">
<div class="industry_item">
<?php
//读取工种
$jobs_query=mysql_query("select * from industry where industryid=0 order by orderid asc");
while($row=mysql_fetch_array($jobs_query)){   
?>
<li itemid="<?php echo $row["id"]?>"><a href="javascript:void(0);"><?php echo $row["title"]?></a></li>
<?php	}?>
<div class="clear"></div>
</div>

<div class="industry_item_box" style="border:0;padding:0px;">
<?php
//读取工种
$jobs_query=mysql_query("select * from industry where industryid=0 order by orderid asc");
while($jobs_row = mysql_fetch_array($jobs_query)){   
?>
<div class="item_box" id="<?php echo $jobs_row["id"]?>">

<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab_item" style="background-color:#FC6;">
<?php
//读取分类
$class_query=mysql_query("select * from industry_class order by id asc");
while($class_row = mysql_fetch_array($class_query)){ 

//判断该类型的工种是否已经录入具体项目
$c_r_query=mysql_query("select count(id) from industry where industryid=".$jobs_row["id"]." and classid=".$class_row["id"]);
$c_r_row  =mysql_fetch_array($c_r_query);
//获取到具体项目
if($c_r_row[0]>0){
?>
  <tr><td width="6%" height="28" align="center" bgcolor="#FFFFFF" class="class_title"><label><input disabled="disabled" title="点击全选对应的<?php echo $class_row["title"]?>项目" type="checkbox" value="1" /><br />
<?php echo $class_row["title"]?></label></td>
  <td width="94%" bgcolor="#FFFFFF">
   <?php
    //读取项目
    $pro_sql  = "select * from industry where industryid=".$jobs_row["id"]." and classid=".$class_row["id"]." order by title asc";
    $pro_query=mysql_query($pro_sql);
    while($pro_row = mysql_fetch_array($pro_query)){ 
	      $pro_ids="|".$pro_row["id"]."|";
    ?>
    <div><label><input disabled="disabled" id="<?php echo $pro_row["id"]?>" title="<?php echo $pro_row["title"]?>" type="checkbox" value="1" <?php if(strpos($rsarrid,$pro_ids)>0){?>checked="checked"<?php }?> /><?php echo $pro_row["title"]?></label></div>
    <?php }?>
  </td></tr>
<?php	}}?>  
</table>

</div>
<?php	}?>

</div>

</div>
</body>
</html>

