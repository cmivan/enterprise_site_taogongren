<?php $this->load->view('public/validform'); ?>
<?php /*?>绑定日期<?php */?>
<script type="text/javascript" src="<?php echo $js_url;?>plus_cal/plus.cal.js"></script>
<script type="text/javascript">
$(function(){
var Tdata=new Date();
Tdata=(Tdata.getMonth()+1)+"/"+Tdata.getDate()+"/"+(Tdata.getFullYear()-12);
<?php /*?>绑定日期<?php */?>
$('#birthday').simpleDatepicker({ chosendate: Tdata , startdate: '1/1/1950', enddate: Tdata });
<?php /*?>完成团队资料,获取赠送金币<?php */?>
$('#gift_ok').click(function(){ JsonAction('<?php echo site_url($c_urls."/userok2gift")?>'); });
});
</script>

<div class="mainbox" box="content_box">
<?php /*?>个人信息页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box">
<form class="validform" method="post">

<?php if($create_2gift==false){?>
<div class="tipbox" style="margin:15px; margin-top:0;margin-bottom:30px;">&nbsp;完善以下资料并 <strong class="chenghong" style="font-weight:lighter; font-family:'宋体'; font-size:13px;"><?php ajax_url($title='上传头像', $c_urls.'/face' );?></strong>后可以领取<span class="chenghong">10</span>个由系统送出的淘工币！ <a href="javascript:void(0);" class="blue" id="gift_ok">已经完善资料了，我要领取！</a> </div>
<?php }?>

<table border="0" cellpadding="0" cellspacing="3" style="margin-left:85px;"><tr><td><div class="val_left"></div></td><td><div class="val_center"></div></td><td><div class="val_right"></div></td></tr>

<tr>
  <td align="right">手机：&nbsp;&nbsp;</td>
  <td colspan="2"><?php echo $info->mobile?> &nbsp;&nbsp;<?php ajax_url($title='<span class="red">修改</span>', $c_urls.'/security' );?></td></tr>
<tr>
  <td align="right">昵称：&nbsp;&nbsp;</td>
  <td><input name="name" type="text" class="inputxt" value="<?php echo $info->name?>" maxlength="6" datatype="s2-6" nullmsg="请输入用户名！" errormsg="昵称至少2个字符,最多6个字符！" /></td>
  <td><div class="validform_checktip">昵称至少2个字符,最多6个字符</div></td></tr>

<tr>
  <td align="right">性别：&nbsp;&nbsp;</td>
  <td><?php
$sex_girl="";
$sex_boy ="";
if($info->sex==1){
   $sex_girl=" checked=checked ";
}else{
   $sex_boy =" checked=checked ";
}
?><label><input name="sex" type="radio" id="sex" value="0" <?php echo $sex_boy?> class="putong"> 
男</label>
&nbsp;&nbsp;<label><input name="sex" type="radio" id="sex" value="1" <?php echo $sex_girl?> class="putong"> 
女</label>
</td><td>&nbsp;</td></tr>
<tr>
  <td align="right">QQ：&nbsp;&nbsp;</td>
  <td>
    <input name="qq" type="text" class="inputxt" id="qq" value="<?php echo $info->qq?>" maxlength="12" datatype="q" nullmsg="请输入您常用的QQ！" errormsg="请输入正确的QQ！" />
    </td>
  <td><div class="validform_checktip">请输入您常用的QQ</div></td></tr>
<tr>
    <td align="right">邮箱/Msn：&nbsp;&nbsp;</td>
    <td colspan="2"><?php echo $info->email?>&nbsp;&nbsp;<?php ajax_url($title='<span class="red">修改</span>', $c_urls.'/security' );?></td>
    </tr>
        <tr><td align="right">籍贯：&nbsp;&nbsp;</td><td class="val_place"><?php
$b_ps = $this->Place_Model->provinces();
$b_cs = $this->Place_Model->citys($info->b_p_id);
$b_as = $this->Place_Model->areas($info->b_c_id);
?><select name="b_p_id" id="b_p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;">
<?php if(!empty($b_ps)){?><?php foreach ($b_ps as $rs){?>
<option value="<?php echo $rs->p_id?>" <?php if($info->b_p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="b_c_id" id="b_c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($b_cs)){?><?php foreach ($b_cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($info->b_c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="b_a_id" id="b_a_id" disabled style="width:74px;"><?php if(!empty($b_as)){?><?php foreach ($b_as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($info->b_a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select></td><td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">现在住处：&nbsp;&nbsp;</td><td class="val_place"><?php
$ps = $this->Place_Model->provinces();
$cs = $this->Place_Model->citys($info->p_id);
$as = $this->Place_Model->areas($info->c_id);
?><select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($info->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($cs)){?><?php foreach ($cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($info->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select><select name="a_id" id="a_id" disabled style="width:74px;"><?php if(!empty($as)){?><?php foreach ($as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($info->a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?>
  <option value="">请选择...</option><?php }?></select></td><td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">生日：&nbsp;&nbsp;</td><td><input name="birthday" type="text" class="inputxt" id="birthday" value="<?php echo $info->birthday?>" datatype="d" nullmsg="请选择日期！" errormsg="日期格式可能有误!"/></td><td><div class="validform_checktip">请选择您的生日!</div></td></tr>
<tr>
  <td align="right">详细地址：&nbsp;&nbsp;</td>
  <td><input name="address" type="text" class="inputxt" id="address" value="<?php echo $info->address?>" maxlength="28" datatype="s4-28" nullmsg="请填写详细地址！" errormsg="详细地址至少4个字，之多28个字！" /></td>
  <td><div class="validform_checktip">详细地址至少4个字，之多28个字！</div></td></tr>
<tr>
  <td align="right">个人简介：&nbsp;&nbsp;</td>
  <td colspan="2"><textarea name="note" class="inputxt" style="width:250px;" id="note"><?php echo $info->note?></textarea></td></tr>

        <tr>
  <td></td>
  <td colspan="2"><input type="submit" value="" class="save_but"/></td></tr>
</table><br><br><br><br></form></div>
</div>