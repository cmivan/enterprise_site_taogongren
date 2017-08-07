<?php $this->load->view('public/header'); ?>
<?php /*?>绑定日期<?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>plus_cal/plus.cal.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>plus_cal/plus.cal.css" />
<?php /*?>
from: http://www.uploadify.com/demos/ 
problem: on upload , the session will change by CI and
solusions: http://codeigniter.org.cn/forums/thread-5760-1-1.html<?php */?>

<script type="text/javascript" src="<?php echo site_url('plugins/uploadify/uploadify_js/retrieval/'.pass_key('retrieval'))?>?show=1"></script>

<script type="text/javascript"> 
$(function(){ 
  <?php /*?>绑定日期<?php */?>
	var SData = getSdate();
	var EData = getEdate();
	$('#endtime').simpleDatepicker({ chosendate: '<?php echo $info->endtime?>' , startdate: SData , enddate: EData });
	$('#job_stime').simpleDatepicker({ chosendate: '<?php echo $info->job_stime?>' , startdate: SData , enddate: EData });
	$('#job_etime').simpleDatepicker({ chosendate: '<?php echo $info->job_etime?>' , startdate: SData , enddate: EData });
  
  <?php /*?>点击图片删除按钮<?php */?>
  $("#upload_img_show a span").live('click',function(){
	 if(confirm('确定删除该图片？')){ $(this).parent().parent().remove(); }
	 });

  <?php /*?>所有项的点击事件<?php */?>
  $(".click_box a").live("click",function(){
	 var isfor =$(this).parent().attr("isfor");
	 var thison=$(this).attr("class");
	 <?php /*?>for 多选<?php */?>
	 if(thison=="on"){
		 $(this).attr("class","");$(this).find("input").attr("checked","");
	 }else{
		 $(this).attr("class","on");$(this).find("input").attr("checked","checked");
	 }
	 <?php /*?>更新被选中的分工种<?php */?>
	 update_industry();
   });
});
<?php /*?>返回工种名称,或id :: t=0 返回id，t=1返回具体值<?php */?>
function update_industry(){
	var industryid="";
	var i_helper="";
	$(".click_box").find("a.on").each(function(){
	  if(industryid==""){industryid=industryid+$(this).attr("id");}else{industryid=industryid+"_"+$(this).attr("id");}
	  if(i_helper==""){i_helper=i_helper+$(this).attr("id");}else{i_helper=i_helper+$(this).attr("id");}
	});
	$("#industryid").val(industryid); $("#i_helper").val(i_helper);
}</script>
<style>
#upload_img_show{width:540px;overflow:hidden;display:none} 
#upload_img_show a{float:left;width:100px; height:100px; overflow:hidden;border:#FFF 3px solid; position:relative}
#upload_img_show a:hover{ background-color:#000; border:#CCC 3px solid;}
#upload_img_show a span{ display:none;}
#upload_img_show a img{ width:100px; }
#upload_img_show a:hover span{font-family:"宋体"; font-size:12px; position:absolute; top:4px; right:4px;height:13px; width:13px; line-height:15px;text-align:center;padding:1px; border:#F60 2px solid; background-color:#000; color:#fff; display:block;}

#retrieval_box a{float:left;padding:2px;width:80px;border:#CCC 1px solid;margin-left:-1px;margin-bottom:-1px;}
#retrieval_box input{border:0;}</style>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>投标页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div><div class="mainbox_box"><div class="content"><form class="validform" method="post"><table border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3"><input type="hidden" name="type_id" id="type_id" value="1" /></td></tr><tr><td height="0" colspan="3" class="edit_box_main"></td></tr><tr><td width="100" align="right">标题：</td><td><input name="title" type="text" class="inputxt" id="title" value="<?php echo $info->title?>" maxlength="18" nullmsg="标题不能为空！" errormsg="标题至少6个字符,最多18个字符" datatype="*6-18" /></td><td width="399"><div class="validform_checktip">标题至少6个字符,最多18个字符</div></td></tr><tr><td align="right">预计费用：</td><td><input name="cost" type="text" class="inputxt" id="cost" value="<?php echo $info->cost?>" maxlength="30" nullmsg="工资不能为空！" errormsg="工资至少1个字符,最多30个字符" datatype="*1-30" /></td><td width="399"><div class="validform_checktip">工资至少1个字符,最多30个字符</div></td></tr><tr><td width="100" align="right">投标类型：</td><td><select name="team_or_men" id="team_or_men" datatype="select" errormsg="投标面向的群体！" style="width:74px;"><option value="all">全部</option><?php if(!empty($team_mens)){
	foreach ($team_mens as $rs){?><option value="<?php echo $rs->id?>" <?php if($rs->id==$info->team_or_men){echo 'selected';}?>><?php echo $rs->title?></option><?php }}?></select><select name="classid" id="classid" datatype="select" errormsg="请选择投标的类型！" style="width:74px;"><option value="">请选择...</option><?php if(!empty($classids)){
	foreach ($classids as $rs){?><option value="<?php echo $rs->id?>" <?php if($rs->id==$info->classid){echo 'selected';}?>><?php echo $rs->title?></option><?php }}?></select></td><td width="399"><div class="validform_checktip"></div></td></tr><tr><td align="right">所在城市：</td><td colspan="2" class="val_place"><?php
$ps = $this->Place->provinces(0);
$cs = $this->Place->citys($info->p_id);
$as = $this->Place->areas($info->c_id);
?><select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($info->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?><option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($cs)){?><?php foreach ($cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($info->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?><option value="">请选择...</option><?php }?></select><select name="a_id" id="a_id" disabled style="width:74px;"><?php if(!empty($as)){?><?php foreach ($as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($info->a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?><option value="">请选择...</option><?php }?></select></td></tr><tr><td align="right">工种：</td><td colspan="2" id="retrieval_box"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="450"><div id="industrys_box" class="click_box selectbox"><div class="box"><?php slistitems($industrys,$info->industryid,"",1)?><div class="clear"></div></div></div><input name="industryid" type="hidden" id="industryid" value="<?php echo $info->industryid?>"/><input name="i_helper" type="hidden" id="i_helper" nullmsg="请选择相应的工种！" datatype="*" value="<?php echo $info->industryid?>" /></td><td><div class="validform_checktip"></div></td></tr></table></td></tr><tr><td width="100" align="right">结束日期：</td><td><input name="endtime" type="text" class="inputxt"id="endtime" value="<?php echo $info->endtime?>" maxlength="18" readonly nullmsg="请选择该投标的结束日期！" datatype="d" /></td><td width="399"><div class="validform_checktip">指在这个日期之前，大家都可以参加投标!</div></td></tr><tr><td width="100" align="right">工期：</td><td colspan="2"><table border="0" cellpadding="0" cellspacing="0"><tr><td><input name="job_stime" type="text" class="inputxt tip" id="job_stime" style="width:88px;" title="这个工程/项目打算在什么时候开始!" value="<?php echo $info->job_stime?>" maxlength="18" readonly nullmsg="请选择工期开始日期！" datatype="d" />        &nbsp;&nbsp;到&nbsp;&nbsp;<input name="job_etime" type="text" class="inputxt tip"  id="job_etime" style="width:88px;" title="这个工程/项目打算在什么时候完成!" value="<?php echo $info->job_etime?>" maxlength="18" readonly nullmsg="请选择工期结束日期！" datatype="d" /></td><td style="padding-left:5px;"><div class="validform_checktip">这里指的是这项工程/项目打算在什么时候开始和完成!</div></td></tr></table></td></tr><tr><td align="right" valign="top">投标描述：</td><td colspan="2" valign="top"><textarea id="note" name="note" datatype="*" style="width:90%;height:120px;"><?php echo $info->note?></textarea></td></tr><tr><td align="right">相关图片：</td><td colspan="2" valign="top"><div id="upload_img"></div><?php if(!empty($pics)){?><div id="upload_img_show" style="display:block"><?php foreach($pics as $P){?><div><a href="javascript:void(0);"><span title="删除该图片!">&times;</span><img src="<?php echo img_retrieval($P->pic)?>" /></a><input type="hidden" name="pic[]" id="pic[]" value="<?php echo $P->pic?>" /></div><?php }?></div><?php }else{?><div id="upload_img_show"></div><?php }?>
</td></tr><tr><td colspan="4" class="edit_box_save_but"><input type="submit" class="save_but" value="" /></td></tr></table></form><div class="clear"></div></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>