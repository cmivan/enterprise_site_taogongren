<?php $this->load->view('public/validform'); ?>
<style>.upload_img {height:135px; width:296px; margin:3px; overflow:hidden}
.upload_img img{height:135px;}</style>
<?php /*?>
from: http://www.uploadify.com/demos/ 
problem: on upload , the session will change by CI and
solusions: http://codeigniter.org.cn/forums/thread-5760-1-1.html<?php */?>

<?php uploadify_js('approve','',1);?>
<?php uploadify_js('approve','',2);?>

<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box">
<form class="validform" method="post">
<table width="88%" border="0" align="center" cellpadding="0" cellspacing="5" style="margin-top:8px;">
<tr><td height="30" colspan="3" class="chenghong" style="font-size:17px;">淘工人网实名认证</td></tr><tr><td height="1" colspan="3" align="right" style="background-image:url(<?php echo $img_url?>ico/xline1.gif); line-height:1px;"></td></tr><tr><td colspan="3">
</td></tr><tr><td width="105" align="left">真实姓名：</td><td width="210"><input name="truename" type="text" class="inputxt" id="truename" value="<?php echo $truename?>" maxlength="6" nullmsg="姓名不能为空！" errormsg="姓名至少2个字符,最多6个字符" datatype="s2-6" /></td>
  <td><div class="validform_checktip">成功认证后,将不能修改</div></td></tr><tr><td align="left">你的身份证号：</td><td><input name="sfz" type="text" class="inputxt" id="sfz" value="<?php echo $sfz?>" maxlength="20" nullmsg="身份证不能为空！" errormsg="请填写正确的身份证号码！" datatype="sm"  /></td><td><div class="validform_checktip">请填写你的身份证号码！</div></td></tr><tr>
  <td align="left">相关证件图片：
    <input name="pic1" type="hidden" id="pic1" value="<?php echo $photo1?>" nullmsg="请上传身份证的正面图！" errormsg="请上传身份证的正面图！" datatype="*"  >
    <input name="pic2" type="hidden" id="pic2" value="<?php echo $photo2?>" nullmsg="请上传身份证的反面图！" errormsg="请上传身份证的反面图！" datatype="*"  ></td>
  <td colspan="2"><div class="validform_checktip">请选择身份证图片并上传！</div></td></tr><tr><td colspan="3" style="padding:5px; background-color:#eee;"><table width="100%" border="0" cellpadding="3" cellspacing="1" style=" background-color:#888">
  <tr>
    <td align="center" bgcolor="#FFFFFF">身份证（正面）</td>
    <td align="center" bgcolor="#FFFFFF">身份证（背面）</td>
    </tr>
  <tr>
    <td height="135" align="center" bgcolor="#FFFFFF">
    <div id="upload_img_show1" style="display:block"><img class="upload_img" src="<?php echo $img_url?><?php echo $photo1?>" /></div></td>
    <td align="center" bgcolor="#FFFFFF">
    <div id="upload_img_show2" style="display:block"><img class="upload_img" src="<?php echo $img_url?><?php echo $photo1?>" /></div></td>
    </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><div id="upload_img1"></div></td>
    <td height="25" align="center" bgcolor="#FFFFFF"><div id="upload_img2"></div></td>
  </tr>
  </table></td>
  </tr><tr>
  <td height="45" colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="28" align="center" valign="top" style="vertical-align:top; padding-top:7px;"><img src="<?php echo $img_url?>ico/ktip.gif" width="16" height="16"></td>
<td valign="top" style="color:#666; line-height:180%;">确认填写的信息无误并且成功上传了身份证的正反面图片后！请点击下面"提交"按钮，我们将在收到你提交的信息的48小时内经行审核处理！</td>
</tr></table></td></tr><tr>
  <td colspan="3" align="center"><input type="submit" value="" id="submit_but" class="save_but"/></td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr></table></form></div></div>