<?php $this->load->view('public/header'); ?>
<?php /*?>倒计时<?php */?><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>timeout.js"></script><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>mod-sms-send.js"></script><style>
.upload_img {height:135px; width:296px; margin:3px; overflow:hidden}
.upload_img img{height:135px;}</style>
<?php /*?>
from: http://www.uploadify.com/demos/ 
problem: on upload , the session will change by CI and
solusions: http://codeigniter.org.cn/forums/thread-5760-1-1.html<?php */?>

<script type="text/javascript" src="<?php echo site_url('plugins/uploadify/uploadify_js/approve/'.pass_key('approve'))?>?id=1"></script>
<script type="text/javascript" src="<?php echo site_url('plugins/uploadify/uploadify_js/approve/'.pass_key('approve'))?>?id=2"></script>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post">
  <table width="88%" border="0" align="center" cellpadding="0" cellspacing="5" style="margin-top:8px;">
  <tr><td height="30" colspan="3" class="chenghong" style="font-size:17px;">淘工人网实名认证</td></tr><tr><td height="1" colspan="3" align="right" style="background-image:url(<?php echo $img_url?>ico/xline1.gif); line-height:1px;"></td></tr><tr><td colspan="3"><div class="tipbox" style="line-height:200%; padding-right:22px;">
1、填写您的真实姓名和身份证号<br />
2、上传相关的证件(身份证正反面照片)，证件内容必须清晰<br />
3、实名认证后不能更改认证信息<hr /><strong><span style="font-weight:bold;color:#F90">【已审核】</span>您的认证申请<span class="red">没有通过</span>本次的审核，您可以对您提交的信息修正后重新提交！</strong><?php if(!empty($errtip)&&$errtip!=""){?><br /><span style="color:#ff0000;font-weight:lighter">原因：<?php echo $errtip?></span><?php }?><br />&nbsp;如果对本次的审核处理存在疑问，可联系在线客服。</div></td></tr><tr><td width="105" align="left">真实姓名：</td><td width="210"><input name="truename" type="text" class="inputxt" id="truename" value="<?php echo $truename?>" maxlength="6" nullmsg="姓名不能为空！" errormsg="姓名至少2个字符,最多6个字符" datatype="s2-6" /></td>
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
    <div id="upload_img_show1" style="display:block"><img class="upload_img" src="<?php echo img_approve($photo1)?>" /></div></td>
    <td align="center" bgcolor="#FFFFFF">
    <div id="upload_img_show2" style="display:block"><img class="upload_img" src="<?php echo img_approve($photo2)?>" /></div></td>
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
        <td valign="top" style="color:#666; line-height:180%;">确认填写的信息无误并且成功上传了身份证的正反面图片后！请点击下面“提交”按钮，我们将在收到你提交的信息的48小时内经行审核处理！</td>
        </tr>
      </table></td>
  </tr><tr>
  <td colspan="3" align="center"><input type="submit" value="" id="submit_but" class="save_but"/></td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr></table></form></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>