<?php $this->load->view('public/validform'); ?>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<form class="validform" method="post"><br>
<table border="0" cellpadding="0" cellspacing="3" style="margin-left:40px;"><tr><td><div class="val_left"></div></td><td class="val_center"><div class="val_center"></div></td><td><div class="val_right"></div></td></tr>

<tr><td align="right">手机：&nbsp;&nbsp;</td><td colspan="2"><?php echo $info->mobile?>&nbsp;&nbsp;<a href="<?php echo site_url($c_urls."/security");?>" class="tip" title="修改已绑定的手机号码"><span class="red">修改</span></a></td></tr>

<tr class="forumRow">
<td align="right" valign="top"><span class="edit_box_edit_td">企业全称</span><span class="edit_box_edit_td">：&nbsp;&nbsp;</span></td>
<td><input name="truename" type="text" id="truename" value="<?php echo $info->truename?>" class="inputxt"
 datatype="*" nullmsg="请填写企业全称!" errormsg="请填写企业全称!" /></td>
<td><div class="validform_checktip">请填写企业全称!</div></td>
</tr>

<tr><td align="right">昵称：&nbsp;&nbsp;</td><td><input name="name" type="text" class="inputxt" value="<?php echo $info->name?>" maxlength="6" datatype="s2-6" nullmsg="请输入用户名！" errormsg="昵称至少2个字符,最多6个字符！" /></td><td><div class="validform_checktip">昵称至少2个字符,最多6个字符</div></td></tr>
<tr><td align="right">业务QQ：&nbsp;&nbsp;</td><td>
<input name="qq" type="text" class="inputxt" id="qq" value="<?php echo $info->qq?>" maxlength="12" /></td>
<td><div class="validform_checktip">请输入您常用的QQ</div></td></tr>
<tr><td align="right">邮箱/Msn：&nbsp;&nbsp;</td>
<td><input name="email" type="text" class="inputxt" id="email" value="<?php echo $info->email?>" maxlength="30" /></td>
<td>&nbsp;</td>
</tr>

<tr class="forumRow"><td align="right" class="edit_box_edit_td">业务电话：&nbsp;&nbsp;</td><td><input name="cardnum" type="text" class="inputxt" id="cardnum" value="<?php echo $info->cardnum?>" maxlength="20" /></td><td>&nbsp;</td></tr>

<tr class="forumRow"><td align="right" class="edit_box_edit_td">接听时间：&nbsp;&nbsp;</td><td><input name="cardnum2" type="text" class="inputxt" id="cardnum2" value="<?php echo $info->cardnum2?>" maxlength="15" /></td>
<td><div class="validform_checktip">格式如：  9:00至18:00</div></td></tr>

<tr><td align="right">创办时间：&nbsp;&nbsp;</td><td>
<?php echo cm_form_select('entry_age',$age_class,'id','title',$info->entry_age);?>
</td><td><div class="validform_checktip"></div></td></tr>

<tr><td align="right">单位所在地：&nbsp;&nbsp;</td><td class="val_place">
<?php
$ps = $this->Place_Model->provinces();
$cs = $this->Place_Model->citys($info->p_id);
$as = $this->Place_Model->areas($info->c_id);
?><select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($info->p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($cs)){?><?php foreach ($cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($info->c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?>
    <option value="">请选择...</option><?php }?></select><select name="a_id" id="a_id" disabled style="width:74px;"><?php if(!empty($as)){?><?php foreach ($as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($info->a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select></td><td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">详细地址：&nbsp;&nbsp;</td><td><input name="address" type="text" class="inputxt" id="address" value="<?php echo $info->address?>" /></td><td>&nbsp;</td></tr>
<tr><td align="right"> 服务简要：&nbsp;&nbsp;</td><td colspan="2">
<textarea name="addr_adv" rows="3" class="inputxt" id="addr_adv" style="width:520px;"><?php echo $info->addr_adv?></textarea></td>
</tr><tr><td>&nbsp;</td><td colspan="2"><input type="submit" value="" class="save_but"/></td></tr></table><br><br><br><br></form></div></div>