<?php $this->load->view('public/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_form.css" /></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content">   <div class="diy_form" style="border:#CCC 1px solid; background-color:#FFF; margin-top:28px; margin-bottom:15px; padding-bottom:10px; padding-top:20px;">
<form enctype="multipart/form-data" method="post" name="upform" target="upload_target" action="<?php echo site_url($c_url."up_avatar/upload")?>" style="padding-left:24px;"><div class="form_description">
请上传一张真人照片，也可以  <a style="color:#cc3300;" href="javascript:void(0);" onClick="useCamera()">使用摄像头!</a></div>
<div class="photoeditbox"><table border="0" cellpadding="0" cellspacing="3"><tr><td><input type="file" name="userfile" id="userfile" style="width:300px; padding:3px; background-color:#FFF"/></td><td><button type="submit" id="face_up_btu" onClick="return checkFile();">&nbsp;</button></td></tr><tr><td colspan="2"><span style="display:none;" id="loading_gif"><img src="<?php echo site_url($up_url)?>/face/avatar_loading.gif" align="absmiddle" />上传中，请稍侯......</span></td></tr></table></div>
<div class="photoeditbox"><iframe src="about:blank" name="upload_target" style="display:none;"></iframe><div id="avatar_editor"></div></div>
</form>

<script type="text/javascript">
<?php /*?>允许上传的图片类型<?php */?>
var extensions = 'jpg,jpeg,gif,png';
<?php /*?>保存缩略图的地址<?php */?>
var saveUrl = '<?php echo site_url($c_url."up_avatar/save/1")?>';
<?php /*?>保存摄象头白摄图片的地址<?php */?>
var cameraPostUrl = '<?php echo site_url($c_url."up_avatar/camera")?>';
<?php /*?>头像编辑器flash的地址<?php */?>
var editorFlaPath = '<?php echo $up_url?>face/avatareditor.swf';
function useCamera()
{
	var content = '<embed height="464" width="514" ';
	content +='flashvars="type=camera';
	content +='&postUrl='+cameraPostUrl+'?&radom=1';
	content += '&saveUrl='+saveUrl+'?radom=1" ';
	content +='pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ';
	content +='allowscriptaccess="always" quality="high" wmode="transparent" ';
	content +='src="'+editorFlaPath+'"/>';
	$("#avatar_editor").html(content);
}
function buildAvatarEditor(pic_id,pic_path,post_type)
{
	var content = '<embed height="464" width="514"'; 
	content+='flashvars="type='+post_type;
	content+='&photoUrl='+pic_path;
	content+='&photoId='+pic_id;
	content+='&postUrl='+cameraPostUrl+'?&radom=1';
	content+='&saveUrl='+saveUrl+'?radom=1"';
	content+=' pluginspage="http://www.macromedia.com/go/getflashplayer"';
	content+=' type="application/x-shockwave-flash"';
	content+=' allowscriptaccess="always" quality="high" wmode="transparent" src="'+editorFlaPath+'"/>';
	$("#avatar_editor").html(content);
}
<?php /*?>提供给FLASH的接口 ： 没有摄像头时的回调方法<?php */?>
function noCamera(){alert("检测到你没有安装摄像头哦!");}
<?php /*?>提供给FLASH的接口：编辑头像保存成功后的回调方法<?php */?>
function avatarSaved(){alert('保存成功!');window.location.reload();}
<?php /*?>提供给FLASH的接口：编辑头像保存失败的回调方法, msg 是失败信息，可以不返回给用户, 仅作调试使用<?php */?>
function avatarError(msg){alert("上传失败!");}
function checkFile()
{
	 var path = $("#userfile").val();
	 var ext = getExt(path);
	 var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
	  if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
	 alert('对不起，只能上传jpg, gif, png类型的图片');
	 return false;
	 }
	 showLoading();
	 return true;
}
function getExt(path){return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();}
function showLoading(){ $("#loading_gif").css({"display":"block"}); }
function hideLoading(){ $("#loading_gif").css({"display":"none"}); }
<?php
//编辑状态加载
if(!empty($face)&is_numeric($photoID)){?>
window.parent.buildAvatarEditor("<?php echo $photoID?>","<?php echo $face?>","photo");<?php }?>
</script>

<div class="clear"></div></div></div>
</div></div>
</div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>