<?php $this->load->view('public/validform'); ?>
<?php $this->load->view_wuser('recruitment/industry_helper'); ?>

<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post"><table border="0" align="center" cellpadding="0" cellspacing="3"><tr><td colspan="3"><input type="hidden" name="type_id" id="type_id" value="1" /></td></tr>
<tr><td height="0" colspan="3" class="edit_box_main"></td></tr><tr><td width="80" align="right">标题：</td><td>
  <input name="title" type="text" class="inputxt" id="title" value="<?php echo $info->title?>" maxlength="18" nullmsg="标题不能为空！" errormsg="标题至少6个字符,最多18个字符" datatype="*6-18" /></td><td width="399"><div class="validform_checktip">标题至少6个字符,最多18个字符</div></td></tr>
<tr><td align="right">工资：</td><td><input name="cost" type="text" class="inputxt" id="cost" value="<?php echo $info->cost?>" maxlength="30" nullmsg="工资不能为空！" errormsg="工资至少1个字符,最多30个字符" datatype="*1-30" /></td><td width="399"><div class="validform_checktip">工资至少1个字符,最多30个字符</div></td></tr>
<tr><td align="right">待遇：</td><td><select name="fuli" id="fuli" style="width:auto"><?php selectboxitem("不包,包吃,包住,包吃住,面议",$info->fuli);?></select></td><td width="399"><div class="validform_checktip"></div></td></tr>
<tr><td align="right">人数：</td><td><input name="num" type="text" class="inputxt" id="num" value="<?php echo $info->num?>" maxlength="8" nullmsg="人数不能为空！" errormsg="人数应为正整数"  datatype="n1-10" /></td><td width="399"><div class="validform_checktip">请填写人数！</div></td></tr>
<tr><td align="right">地址：</td><td class="val_place"><?php
$ps = $this->Place_Model->provinces();
$cs = $this->Place_Model->citys($info->p_id);
$as = $this->Place_Model->areas($info->c_id);
?><select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($info->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($cs)){?><?php foreach ($cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($info->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="a_id" id="a_id" disabled style="width:74px;"><?php if(!empty($as)){?><?php foreach ($as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($info->a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select></td><td><div class="validform_checktip"></div></td></tr>
<tr>
  <td align="right">详细地址：</td>
  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="54%"><input name="c_addr" type="text" class="inputxt" id="c_addr" style="width:350px;" value="<?php echo $info->c_addr?>" maxlength="100" nullmsg="详细地址不能为空！" errormsg="详细地址至少5个字符,最多70个字符" datatype="*5-70"  /></td>
        <td width="46%"><div class="validform_checktip">详细地址至少5个字符,最多70个字符</div></td>
        </tr>
      </table></td></tr>
<tr><td align="right">工种：</td><td colspan="2" id="retrieval_box"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="450"><div id="industrys_box" class="click_box selectbox"><div class="box"><?php echo SelectListItems($industrys,$info->industryid,"",1)?><div class="clear"></div></div></div><input name="industryid" type="hidden" id="industryid" value="<?php echo $info->industryid?>"/><input name="i_helper" type="hidden" id="i_helper" nullmsg="请选择相应的工种！" datatype="*" value="<?php echo str_replace('_','',$info->industryid)?>" /></td><td><div class="validform_checktip"></div></td></tr></table></td></tr>
<tr><td align="right" valign="top">描述：</td><td colspan="2" valign="top">

<?php /*?>编辑器<?php */?>
<?php echo $this->kindeditor->js('content',$info->content,'100%','210px');?>

</td></tr><tr><td colspan="4" class="edit_box_save_but"><input type="submit" class="save_but" value="" /></td></tr></table></form>
</div></div>