<?php /*?>表单<?php */?><script type="text/javascript" src="<?php echo $js_url;?>validform/js/validform.js"></script><script type="text/javascript">
$(function(){
  <?php /*?>绑定表单<?php */?>
  $(".validform").validform({
	  tiptype:2,
	  ajaxurl:'<?php echo site_url($c_urls.'/step_1')?>',
	  callback:function(data){
		  <?php /*?>这里执行回调操作<?php */?>
		  if(data.cmd=="y"){
			  <?php /*?>公用方法关闭信息提示框<?php */?>
			  setTimeout(function(){
				$.Hidemsg();
				<?php /*?>装入第二步<?php */?>
				tb_show('重新绑定手机','<?php echo site_url($c_url.'bind_mobile')?>?height=180&width=450&modal=false',false);
			  },1500);
		  }else if(data.cmd=="n"){
			  setTimeout(function(){$.Hidemsg();},1800);
		  }
	  }
  });
});</script>
<?php /*?>倒计时<?php */?><script type="text/javascript" src="<?php echo $js_url;?>sms_timeout.js"></script><script type="text/javascript" src="<?php echo site_url('global_v1/sms_js/bind')?>"></script><form class="validform" method="post"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="3" style="margin-top:8px;"><tr><td width="105" height="25" align="right">原手机：</td><td><?php echo substr_replace($mobile,"*****",4).substr($mobile,9,2);?><input name="mobile" type="hidden" id="mobile" value="00000000000" /></td></tr><tr><td colspan="2" class="page_main_line" style="padding:0;">&nbsp;</td></tr><tr><td height="25" align="right">验证码：</td><td class="td30"><table border="0" cellpadding="0" cellspacing="0"><tr><td><input name="code" id="code" type="text" class="inputxt" maxlength="4" style="width:120px;" datatype="p" nullmsg="请输入验证码！" errormsg="请填写正确的！"/></td><td><label id="send_sms"><a href="javascript:void(0);">获取验证码</a></label></td></tr></table></td></tr><tr><td>&nbsp;</td><td align="left" style="color:#F00;"><button type="submit" class="cm_but btu_next">&nbsp;</button></td></tr></table></form>