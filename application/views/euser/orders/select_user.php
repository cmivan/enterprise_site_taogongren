<script>
$(function(){
  $('#order_select_user').find('li').hover(
	  function(){ if($(this).attr('class')!='select'){ $(this).attr('class','over'); } },
	  function(){ if($(this).attr('class')!='select'){ $(this).attr('class',''); } }
  );
  $('#order_select_user').find('li').click(function(){
	  $(this).parent().find('li').attr('class','');
	  $(this).attr('class','select');
	  $('.cm_btu').css({"display":"block"});
  });
  $('#next_step').click(function(){
	  var itemsize = $('#order_select_user').find('.select').size();
	  if(itemsize!=1){
		  alert('你还没选择要下单给哪位工人!');
		  $('#order_select_user').fadeOut().fadeIn(200);
		  return false;
	  }else{
		  var uid = $('#order_select_user').find('.select').find('span').attr('uid');
		  PageAjax('<?php echo site_url($c_urls);?>?to_uid=' + uid);
	  }
  });
});
</script>

<div class="mainbox" box="content_box">
<?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_url); ?> </div>
<div class="mainbox_box"><div class="content">
<table width="100%" border="0" cellpadding="2" cellspacing="6" class="order_select_box">           
<tr><td height="20" valign="top">
<div class="tipbox tipbox_edit">
第一步：请选择要下单给哪个工人：
<br><span>( 温馨提示：请坚持线上交易，保障安全! )</span>
</div>
</td></tr><tr><td height="400" valign="top">
<div id="order_select_user">
<?php
  if(!empty($list)){
  foreach($list as $item){
?>
<li><img src="<?php echo $this->User_Model->faceB( $this->User_Model->photoID($item->fuid) )?>" /><br><span uid="<?php echo $item->fuid?>"><?php echo $item->name?></span></li>
<?php }}else{?> <a href="<?php echo site_url("search")?>" cmd='null' target="_blank">到搜索页面看看...</a> <?php }?>
<div class="clear"></div>
</div>

<div class="clear"></div>

<table border="0" cellspacing="8">
<tr><td valign="bottom">选择好你要下单给哪位工人，然后点击"下一步" 或 <a href="<?php echo site_url("search")?>" cmd='null' target="_blank" style="color:#06F;">通过搜索，有更多选择 <span style="font-family:'宋体';font-size:9px">&gt;&gt;</span></a></td>
<td><span class="cm_btu" style="display:none"><a href="javascript:void(0);" class="buttom" id="next_step">下一步</a></span></td></tr>
</table>
</td></tr></table>
<div class="clear"></div></div></div></div>