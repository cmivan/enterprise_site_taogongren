<?php /*?>登录向导<?php */?>
<script language="javascript">
$(function(){
   $('#adv_close').click(function(){ Tbox_close(); });
   $('#isshow').click(function(){
	  var labelsty = '0';
	  var labelchecked = $('#isshow').attr('checked');
	  if(labelchecked){ labelsty = '1'; }
	  $('#isshow').parent().find('span').load('<?php echo site_url('task/login_task')?>?checked='+labelsty,function(){$(this).attr('class','red').fadeOut().fadeIn(300);});});
 });
</script>
<style type="text/css">
#login_nav_box{margin-top:12px;}
#login_nav_box td,#login_nav_box div,#login_nav_box a,#login_nav_box .chenghong2{font-size:12px;}
</style>

<?php if($classid==0){?>
<table border="0" align="center" cellpadding="0" cellspacing="5" id="login_nav_box">
  <tr>
  <td height="25" align="left" valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" /></td>
  <td align="left">前往 <a href="<?php echo site_url($c_url."center")?>" target="_top" class="chenghong2" style="color:#F90;">[ 管理中心 ]</a> 完善个人信息,可以获取 <span class="chenghong"><?php echo $zscost?></span>个淘工币 奖励!</td>
  </tr>
  <tr><td height="25" align="left" valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" /></td>
  <td height="25" align="left">先看看，稍后再去完善!&nbsp; <a href="javascript:void();" id="adv_close" class="blue"><strong>[ 关闭提示 ]</strong></a></td>
  </tr>
  <tr>
  <td valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" />&nbsp;</td>
  <td align="left"><label><input type="checkbox" name="isshow" id="isshow" /> <span>下次登录后不用再提醒</span></label> </td></tr></table>
  <?php }elseif($classid==1){?>
  <table border="0" align="center" cellpadding="0" cellspacing="5" id="login_nav_box">
  <tr>
  <td height="25" valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" /></td>
  <td align="left">前往 <a href="<?php echo site_url($c_url."retrieval/add")?>" target="_top" class="chenghong2" style="color:#F90;">[ 我的投标 ]</a> 发布任务信息,可以获取<span class="chenghong">1元</span> 奖励!</td>
  </tr>
  <tr><td height="25" valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" /></td>
  <td height="25" align="left">先看看，稍后再去发布任务!&nbsp; <a href="javascript:void();" id="adv_close" class="blue"><strong>[ 关闭提示 ]</strong></a></td>
  </tr>
  <tr><td valign="middle"><img src="<?php echo $img_url?>ico/edit_dian.gif" width="15" height="8" />&nbsp;</td>
  <td align="left"><label><input type="checkbox" name="isshow" id="isshow" /> <span>下次登录后不用再提醒</span></label>
  </td></tr></table>
<?php }?>