<?php $this->load->view('public/header'); ?>
<style>
.upload_img {height:135px; width:296px; margin:3px; overflow:hidden}
.upload_img img{height:135px;}</style></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post">
  <table width="88%" border="0" align="center" cellpadding="0" cellspacing="5" style="margin-top:8px;">
  <tr><td height="30" colspan="2" class="chenghong" style="font-size:17px;">淘工人网实名认证</td></tr><tr><td height="1" colspan="2" align="right" style="background-image:url(<?php echo $img_url?>ico/xline1.gif); line-height:1px;"></td></tr><tr><td colspan="2"><div class="tipbox" style="line-height:200%; padding-right:22px;">
1、填写您的真实姓名和身份证号<br />
2、上传相关的证件(身份证正反面照片)，证件内容必须清晰<br />
3、实名认证后不能更改认证信息 <hr /><strong><span style="color:#F90">【已审核】</span>你已经<span class="red">成功通过</span>实名认证！</strong></div></td></tr><tr><td width="90" align="right">真实姓名：</td><td><?php echo $truename?></td>
  </tr><tr><td align="right">你的身份证号：</td><td style="font-family:Verdana, Geneva, sans-serif; font-size:14px;"><?php echo $sfz?></td></tr><tr><td colspan="2" style="padding:5px; background-color:#eee;"><div style="position:relative"><div class="tip" title="成功通过淘工人认证!" style="position:absolute; left:235px; top:-45px; width:85px; height:85px;background-image:url(<?php echo $img_url?>ico/tao_ok.gif);">&nbsp;</div></div><table width="100%" border="0" cellpadding="3" cellspacing="1" style=" background-color:#888">
  <tr>
    <td align="center" bgcolor="#FFFFFF">身份证（证面）</td>
    <td align="center" bgcolor="#FFFFFF">身份证（背面）</td>
    </tr>
  <tr>
    <td height="135" align="center" bgcolor="#FFFFFF"><div class="upload_img" id="upload_img_show_1"><a href="<?php echo $photo1?>" target="_blank"><img src="<?php echo $photo1?>" width="300"></a></div></td>
    <td align="center" bgcolor="#FFFFFF"><div class="upload_img" id="upload_img_show_2"><a href="<?php echo $photo2?>" target="_blank"><img src="<?php echo $photo2?>" width="300"></a></div></td>
    </tr></table></td>
  </tr><tr>
  <td height="45" colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="28" align="center" valign="top" style="vertical-align:top; padding-top:2px;"><img src="<?php echo $img_url?>ico/ktip.gif" width="16" height="16"></td>
        <td valign="top" style="color:#666; line-height:180%;">您的认证信息已经通过审核，谢谢您的支持！</td>
        </tr>
      </table></td>
  </tr><tr>
  <td colspan="2" align="center">&nbsp;</td></tr></table></form></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>