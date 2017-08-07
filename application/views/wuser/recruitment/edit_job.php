<?php $this->load->view('public/header'); ?>
<script type="text/javascript">
$(function(){
    <?php /*?>所有项的点击事件<?php */?>
	$(".click_box a").live("click",function(){
	   var isfor=$(this).parent().attr("isfor");
	   var thison=$(this).attr("class");
	   <?php /*?>for 多选<?php */?>
	   if(thison=="on"){
		   $(this).attr("class","");
		   $(this).find("input").attr("checked","");
	   }else{
		   $(this).attr("class","on");
		   $(this).find("input").attr("checked","checked");
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
	$("#industryid").val(industryid);
	$("#i_helper").val(i_helper);
}
</script>
<style>#retrieval_box a{padding:2px;width:80px;border:#CCC 1px solid;margin-left:-1px;margin-bottom:-1px;display:inline-block;}
#retrieval_box input{border:0;}</style>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3"><input type="hidden" name="type_id" id="type_id" value="2" /></td></tr>
<tr><td height="0" colspan="3" class="edit_box_main"></td></tr><tr><td width="80" align="right">标题：</td><td>
  <input name="title" type="text" class="inputxt" id="title" value="<?php echo $info->title?>" maxlength="18" nullmsg="标题不能为空！" errormsg="标题至少6个字符,最多18个字符" datatype="*6-18" /></td><td width="399"><div class="validform_checktip">标题至少6个字符,最多18个字符</div></td></tr>
<tr><td align="right">工资：</td><td><input name="cost" type="text" class="inputxt" id="cost" value="<?php echo $info->cost?>" maxlength="30" nullmsg="工资不能为空！" errormsg="工资至少1个字符,最多30个字符" datatype="*1-30" /></td><td width="399"><div class="validform_checktip">这里填写你期望的工资，工资至少1个字符,最多30个字符</div></td></tr>
<tr><td align="right">待遇要求：</td><td><select name="fuli" id="fuli" style="width:auto"><?php selectboxitem("不要求,包吃,包住,包吃住,面议",$info->fuli);?></select></td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr>
  <td align="right">地址：</td>
  <td class="val_place"><?php
$ps = $this->Place->provinces(0);
$cs = $this->Place->citys($info->p_id);
$as = $this->Place->areas($info->c_id);
?>
  <select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;">
  <?php if(!empty($ps)){?>
  <?php foreach ($ps as $rs){?>
  <option value="<?php echo $rs->p_id?>" <?php if($info->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option>
  <?php }}else{?>
    <option value="">请选择...</option>
  <?php }?>
  </select>
  <select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;">
  <?php if(!empty($cs)){?>
  <?php foreach ($cs as $rs){?>
  <option value="<?php echo $rs->c_id?>" <?php if($info->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option>
  <?php }}else{?>
    <option value="">请选择...</option>
  <?php }?>
  </select>
  <select name="a_id" id="a_id" disabled style="width:74px;">
  <?php if(!empty($as)){?>
  <?php foreach ($as as $rs){?>
  <option value="<?php echo $rs->a_id?>" <?php if($info->a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option>
  <?php }}else{?>
    <option value="">请选择...</option>
  <?php }?>
  </select>
  </td>
  <td><div class="validform_checktip"></div></td></tr>
<tr>
  <td align="right">现在住处：</td>
  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="54%"><input name="c_addr" type="text" class="inputxt" id="c_addr" style="width:350px;" value="<?php echo $info->c_addr?>" maxlength="100" nullmsg="详细地址不能为空！" errormsg="详细地址至少5个字符,最多70个字符" datatype="*5-70"  /></td>
        <td width="46%"><div class="validform_checktip">详细地址至少5个字符,最多70个字符</div></td>
        </tr>
      </table></td></tr>
<tr><td align="right">擅长工种：</td><td colspan="2" id="retrieval_box"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="450"><div id="industrys_box" class="click_box selectbox"><div class="box"><?php slistitems($industrys,$info->industryid,"",1)?><div class="clear"></div></div></div><input name="industryid" type="hidden" id="industryid" value="<?php echo $info->industryid?>"/><input name="i_helper" type="hidden" id="i_helper" nullmsg="请选择相应的工种！" datatype="*" value="<?php echo str_replace('_','',$info->industryid)?>" /></td><td><div class="validform_checktip"></div></td></tr></table></td></tr>
<tr><td align="right" valign="top">描述：</td><td colspan="2" valign="top">
  
<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js('content',$info->content,'100%','210px');?>

</td></tr><tr><td colspan="4" class="edit_box_save_but"><input type="submit" class="save_but" value="" /></td></tr>
</table></form>
</div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>