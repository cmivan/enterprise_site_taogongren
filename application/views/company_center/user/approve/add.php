<?php $this->load->view('public/header'); ?>
<?php /*?>倒计时<?php */?><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>timeout.js"></script><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>mod-sms-send.js"></script><style>
.upload_img {height:135px; width:296px; margin:3px; overflow:hidden}
.upload_img img{height:135px;}</style><?php /*?>
from: http://www.uploadify.com/demos/ 
problem: on upload , the session will change by CI and
solusions: http://codeigniter.org.cn/forums/thread-5760-1-1.html<?php */?>

<link href="<?php echo $js_url?>uploadify/uploadify.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="<?php echo $js_url?>uploadify/jquery.uploadify.v2.1.4.js"></script><script type="text/javascript" src="<?php echo $js_url?>uploadify/swfobject.js"></script><script type="text/javascript"> 
$(function(){ 
  <?php /*?>上传图片模块1<?php */?>
  $('#upload_img_1').uploadify({ 
	'uploader':'<?php echo $js_url?>uploadify/uploadify.swf',
	'script':'<?php echo site_url("plugins/uploadify")?>',
	'folder':'<?php echo $js_url?>uploadify',
	'cancelImg':'<?php echo $js_url?>uploadify/cancel.png','buttonImg':'<?php echo $img_url?>my/upimg_but.gif',
	'auto':true,'multi': false,
	'fileDesc':'请选择jpg、png、gif文件','fileExt':'*.jpg;*.png;*.gif',
	'simUploadLimit':5,'sizeLimit': 86400,
	<?php /*?>'fileDataName': "userfile",<?php */?>
	'onComplete': function(event,queueID,fileObj,response,data) {
		if(response!=""&&response!="0"){
			$('#upload_img_show_1 img').attr('src','<?php echo $uploads_url;?>'+response);
			$('#photo1').val('<?php echo $uploads_url;?>'+response); }else{
				alert('上传失败!请查看所上传的文件格式是否有误或大小是否小于200K!');
				}
		$('#upload_img_show_1').fadeIn(250);
	 },
	'onError': function(event, queueID, fileObj) { alert("文件: " + fileObj.name + "上传失败"); } 
  });
  <?php /*?>上传图片模块2<?php */?>
  $('#upload_img_2').uploadify({ 
	'uploader':'<?php echo $js_url?>uploadify/uploadify.swf',
	'script':'<?php echo site_url("plugins/uploadify")?>',
	'folder':'<?php echo $js_url?>uploadify',
	'cancelImg':'<?php echo $js_url?>uploadify/cancel.png','buttonImg':'<?php echo $img_url?>my/upimg_but.gif',
	'auto':true,'multi': false,
	'fileDesc':'请选择jpg、png、gif文件','fileExt':'*.jpg;*.png;*.gif',
	'simUploadLimit':5,'sizeLimit': 86400,
	'onComplete': function(event,queueID,fileObj,response,data) {
		if(response!=""&&response!="0"){
			$('#upload_img_show_2 img').attr('src','<?php echo $uploads_url;?>'+response);
			$('#photo2').val('<?php echo $uploads_url;?>'+response); }else{
				alert('上传失败!请查看所上传的文件格式是否有误或大小是否小于200K!');
				}
		$('#upload_img_show_2').fadeIn(250);
	 },
	'onError': function(event, queueID, fileObj) { alert("文件: " + fileObj.name + "上传失败"); } 
  });
 
});</script>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><form class="validform" method="post">
  <table width="88%" border="0" align="center" cellpadding="0" cellspacing="5" style="margin-top:8px;">
  <tr><td height="30" colspan="3" class="chenghong" style="font-size:17px;">淘工人网实名认证</td></tr><tr><td height="1" colspan="3" align="right" style="background-image:url(<?php echo $img_url?>ico/xline1.gif); line-height:1px;"></td></tr><tr><td colspan="3">
</td></tr><tr><td width="105" align="left">真实姓名：</td><td width="210"><input name="truename" type="text" class="inputxt" id="truename" value="<?php echo $truename?>" maxlength="6" nullmsg="姓名不能为空！" errormsg="姓名至少2个字符,最多6个字符" datatype="s2-6" /></td>
  <td><div class="validform_checktip">成功认证后,将不能修改</div></td></tr><tr><td align="left">你的身份证号：</td><td><input name="sfz" type="text" class="inputxt" id="sfz" value="<?php echo $sfz?>" maxlength="20" nullmsg="身份证不能为空！" errormsg="请填写正确的身份证号码！" datatype="sm"  /></td><td><div class="validform_checktip">请填写你的身份证号码！</div></td></tr><tr>
  <td align="left">相关证件图片：
    <input name="photo1" type="hidden" id="photo1" value="<?php echo $photo1?>" nullmsg="请上传身份证的正面图！" errormsg="请上传身份证的正面图！" datatype="*"  >
    <input name="photo2" type="hidden" id="photo2" value="<?php echo $photo2?>" nullmsg="请上传身份证的反面图！" errormsg="请上传身份证的反面图！" datatype="*"  ></td>
  <td colspan="2"><div class="validform_checktip">请选择身份证图片并上传！</div></td></tr><tr><td colspan="3" style="padding:5px; background-color:#eee;"><table width="100%" border="0" cellpadding="3" cellspacing="1" style=" background-color:#888">
  <tr>
    <td align="center" bgcolor="#FFFFFF">身份证（证面）</td>
    <td align="center" bgcolor="#FFFFFF">身份证（背面）</td>
    </tr>
  <tr>
    <td height="135" align="center" bgcolor="#FFFFFF"><div class="upload_img" id="upload_img_show_1"><img src="<?php echo $img_url?><?php echo $photo1?>" width="300"></div></td>
    <td align="center" bgcolor="#FFFFFF"><div class="upload_img" id="upload_img_show_2"><img src="<?php echo $img_url?><?php echo $photo2?>" width="300"></div></td>
    </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFFFF"><div id="upload_img_1"></div></td>
    <td height="25" align="center" bgcolor="#FFFFFF"><div id="upload_img_2"></div></td>
  </tr></table></td>
  </tr><tr>
  <td height="45" colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="28" align="center" valign="top" style="vertical-align:top; padding-top:7px;"><img src="<?php echo $img_url?>ico/ktip.gif" width="16" height="16"></td>
        <td valign="top" style="color:#666; line-height:180%;">确认填写的信息无误并且成功上传了身份证的正反面图片后！请点击下面“提交”按钮，我们将在收到你提交的信息的48小时内经行审核处理！</td>
        </tr>
      </table></td>
  </tr><tr>
  <td colspan="3" align="center"><input id="submit_but" type="image" src="<?php echo $img_url?>submit_but.gif" style="width:82px; height:31px; border:0; padding:0; margin:0;" align="absmiddle" /></td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr><tr>
  <td colspan="3" align="center">&nbsp;</td></tr></table></form></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>