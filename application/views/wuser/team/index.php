<?php $this->load->view('public/validform'); ?>
<?php
$T = false;
function editbox($key,$val,$T=false){
   if($T){ echo '<script>KEbox("'.$key.'");</script>'; }
   echo '<textarea id="'.$key.'" name="'.$key.'" style="width:530px;height:185px;"';
   echo ' datatype="*" nullmsg="请输入内容!" errormsg="请输入内容!" >'.$val.'</textarea>';
}
?>
<?php /*?>复制代码<?php */?>
<script charset="utf-8" src="<?php echo $js_url?>clipboard/ZeroClipboard.js"></script>
<script charset="utf-8" src="<?php echo $edit_url?>k/kindeditor.js"></script>
<script language="javascript" type="text/javascript">
$(function(){
<?php /*?>完成团队资料,获取赠送金币<?php */?>
$('#gift_ok').click(function(){ JsonAction('<?php echo site_url($c_urls."/teamok2gift")?>'); });
<?php /*?>团队导航<?php */?>
$(".team_nav").find("a[nav=y]").click(function(){ var index=$(this).index(); seltab(index); });
<?php /*?>提交表单<?php */?>
$(".save_but").click(function(){
  var tabval;var index;var tabtitle;
  $('textarea').each(function(){
	 tabval = $(this).val(); index = $('textarea').index($(this));
	 tabtitle = $(".team_nav").find("a[nav=y]").eq(index).text();
	 if(tabval==''){alert('请填写' + tabtitle + '!');seltab(index);return false;}
  });
  });
});
function seltab(index)
{
  $(".team_nav").find("a[nav=y]").attr("class","");
  $(".team_nav").find("a[nav=y]").eq(index).attr("class","on");
  $(".team_tab_item").css({"display":"none"});
  $(".team_tab_item").eq(index).css({"display":"block"});
}
<?php if($T){?>//编辑器
function KEbox(keyid){
 $("#"+keyid).css({"visibility":"hidden"});
  KE.show({id : keyid,resizeMode : 1,allowPreviewEmoticons : false,allowUpload : true, items : ['image','|', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'underline','removeformat', '|', 'justifyleft','insertunorderedlist']});}
<?php }?>
</script>

<style>
.team_edit_box{display:block; width:660px; margin:auto; background-color:#F3F3F3; border:#CCC 1px solid; padding:2px;}
.team_edit_save{padding-top:8px; text-align:center;}.team_tab_item{ display:none;}
.team_nav{line-height:22px;height:22px;border-bottom:#CCC 1px solid;margin-bottom:0px;}
.team_nav a{background-color:#CCC;padding-left:10px;padding-right:10px;float:left;margin-right:1px;}
.team_nav a:hover{background-color:#FC0;}
.team_nav a.on{background-color:#FC0;padding-left:10px;padding-right:10px;float:left;margin-right:1px;}
</style>
<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box">
<?php if($is_sys_inviter==true){?>

  <?php if($create_2gift==false){?>
  <div class="tipbox" style="margin-bottom:22px;">
  成功创建团队并完善团队信息以及<a href="<?php echo site_url($c_urls.'/face')?>" class="tip red" title="进入团队头像页面上传头像!">上传团队头像</a>后可以领取<span class="chenghong">5</span>个由系统送出的淘工币！
  <a href="javascript:void(0);" class="blue" cmd='null' id="gift_ok">已经完善资料了，我要领取！</a></div>
  <?php }?>
  
<form class="validform" method="post">
<!--基本信息-->
<div class="team_edit_box">
<table border="0" align="center" cellpadding="0" cellspacing="3">

<tr><td><div class="val_left"></div></td>
<td><div class="val_center"></div></td><td width="280"><div class="val_right"></div></td></tr>

<?php if(!empty($name)){?>
<tr><td>&nbsp;</td>
  <td colspan="2"><table border="0" cellpadding="0" cellspacing="1">
    <tr>
      <td width="95" align="left"><div class="userface team_face"><a href="<?php echo site_url($c_urls.'/face')?>"><img src="<?php echo $this->User_Model->faceB($photoID)?>" /></a></div></td>
      <td valign="top" style="vertical-align:bottom;">
        团队名称：<?php echo $name?>
        <br>
        创建时间：<?php echo dateYMD($addtime)?>
        <br>
        <a href="<?php echo site_url($c_urls.'/face')?>" class="blue">点击修改头像</a></td>
      </tr>
  </table></td>
</tr>

<tr align="center"><td colspan="3" class="yzpage_line">&nbsp;</td></tr>
<?php }?>

<tr><td align="right">名称：&nbsp;&nbsp;</td>
<td><input name="name" type="text" class="inputxt" value="<?php echo $name?>" maxlength="6" datatype="s2-6" nullmsg="请输入用户名！" errormsg="昵称至少2个字符,最多6个字符！" /></td><td><div class="validform_checktip">昵称至少2个字符,最多6个字符</div></td></tr>
<tr><td align="right">所在地：&nbsp;&nbsp;</td><td class="val_place">
<select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled style="width:74px;"><?php if(!empty($ps)){?><?php foreach ($ps as $rs){?><option value="<?php echo $rs->p_id?>" <?php if($p_id==$rs->p_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->p_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select><select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled style="width:74px;"><?php if(!empty($cs)){?><?php foreach ($cs as $rs){?><option value="<?php echo $rs->c_id?>" <?php if($c_id==$rs->c_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->c_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select><select name="a_id" id="a_id" disabled style="width:74px;"><?php if(!empty($as)){?><?php foreach ($as as $rs){?><option value="<?php echo $rs->a_id?>" <?php if($a_id==$rs->a_id){echo ' class="inputSelet" selected';}?> ><?php echo $rs->a_name?></option><?php }}else{?>
<option value="">请选择...</option><?php }?></select></td><td><div class="validform_checktip"></div></td></tr>
<tr><td align="right">详细地址：&nbsp;&nbsp;</td><td><input name="address" type="text" class="inputxt" id="address" value="<?php echo $address?>" maxlength="28" datatype="s4-28" nullmsg="请填写详细地址！" errormsg="详细地址至少4个字，之多28个字！" /></td><td><div class="validform_checktip">详细地址至少4个字，之多28个字！</div></td></tr>

<tr><td align="right" style="vertical-align:top; padding-top:35px;">其他信息：&nbsp;&nbsp;</td><td colspan="2">
  <div class="team_nav">
  <a nav="y" href="javascript:void(0);" cmd='null' class="on">团队简介</a>
  <a nav="y" href="javascript:void(0);" cmd='null'>服务项目</a>
  <a nav="y" href="javascript:void(0);" cmd='null'>服务地区</a>
  <a nav="y" href="javascript:void(0);" cmd='null'>参考报价</a>
  </div>
  
  <?php /*?>团队简介<?php */?>
  <div class="team_tab_item" style="display:block"><?php editbox('note',$note,$T);?></div>
  <?php /*?>服务项目<?php */?>
  <div class="team_tab_item"><?php editbox('team_fwxm',$team_fwxm,$T);?></div>
  <?php /*?>服务地区<?php */?>
  <div class="team_tab_item"><?php editbox('team_fwdq',$team_fwdq,$T);?></div>
  <?php /*?>参考报价<?php */?>
  <div class="team_tab_item"><?php editbox('team_ckbj',$team_ckbj,$T);?></div>
  
</td></tr>
<tr><td align="right"></td>
<td colspan="2" class="red">* 注意填写的内容不要过长以及不要在内容中加入特殊字符!</td></tr>

<tr><td align="right"></td><td colspan="2">
<input type="submit" value="" class="save_but"/>
</td></tr></table>
</div><br>
</form>
<?php }else{?>  
<div class="alertbox" style="margin-top:0;">
<br><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td><span class="chenghong2" style="text-decoration:none; font-size:18px;">想创建属于你的团队吗？</span>
<br><br>
现在你可以通过你的专用链接邀请好友加入，只要邀请&nbsp;<span class="chenghong">3</span>&nbsp;位好友成功注册即可以创建团队! <br /></td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" style="margin-top:8px;">
<form id="form1" name="form1" method="post" action="">
<tr><td height="12" align="center"><table border="0" cellpadding="0" cellspacing="0">
<tr><td width="65" align="left">邀请链接：</td>
<td align="center"><input name="url" type="text" id="url" style="width:378px;padding:2px;" value="<?php echo $inviter_url?>" readonly onClick="this.select();" onMouseOver="this.select();" /></td>
<td width="40" align="center"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center">
<div id="d_clip_container" style="position:relative;"><a href="javascript:void(0);" id="copy">复制</a></div>
</td></tr></table></td></tr></table></td></tr>
<tr><td height="8" align="center"></td></tr><tr>
<td height="25">
<span style="font-family:宋体">&middot;</span>邀请链接可以发送给多个朋友<br />
<span style="font-family:宋体">&middot;</span>你可以通过QQ、MSN和邮件发给你的朋友，邀请他注册淘团队<br />
<span style="font-family:宋体">&middot;</span>当你邀请的朋友成功注册后，会自动成为你的好友！<br />
</td></tr></form></table>
<br><br>
</div>
<?php }?> 
</div></div>