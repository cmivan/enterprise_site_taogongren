<?php if(is_num($e_id)==false){?>
  <?php /*?>表单<?php */?>
  <?php $this->load->view('public/validform'); ?>
  <?php /*?>评级打分<?php */?>
  <script language="javascript" type="text/javascript" src="<?php echo $js_url?>mod_common_star.js"></script>
<?php }?>

<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>mod_star.css" />
<?php
//评分绑定
if(!empty($e_scorarr))
{
	echo '<script language="javascript" type="text/javascript">';
	echo '$(function(){';		 
	foreach($e_scorarr as $item){
		$item_id = $item['id'];
		$item_scor = $item['scor'];
		echo '$(".pingji dt#dpStar'.$item_id.'").removeClass().addClass("selectS'.$item_scor.'");';
		if($item_scor!=0)
		{
			echo '$(".pingji dt#dpStar'.$item_id.'").find(".scor").html("<span class=chenghong2>'.$item_scor.'</span>分");';
		}
	}
	echo '});</script>';
}
?>
<br />

<?php
//存在相应的评分ID则显示评分结果，否则显示其他的
if(is_num($e_id)||($cmd=='tab'&&get_num($e_id)==false)){?>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="5">
<?php /*显示切换框*/
if($show_tab){?>
<tr><td width="1104" valign="bottom"><div class="common_tab">
<a class="thickbox<?php echo $common_tab[0]?>" title="查看订单评分" href="<?php echo reUrl('cmd=null',1)?>">我给出的评分</a>
<a class="thickbox<?php echo $common_tab[1]?>" title="查看订单评分" href="<?php echo reUrl('cmd=tab',1)?>">对方给我的评分</a>
<div class="clear"></div></div></td></tr>
<?php }?>

<?php if($cmd=='tab'&&get_num($e_id)==false){?>
<tr><td align="center">暂时未评分...</td></tr>
<?php }else{?>

<?php if(!empty($r_user_links)&&!empty($r_content)){?>
<tr><td width="1104" valign="bottom">
  <?php echo $r_user_links?>&nbsp;&nbsp;订单信息：<?php echo $r_content?><input type="hidden" id="oid" value="<?php echo $keyid?>" />
</td></tr>
<?php }?>
  
<tr><td valign="bottom" style="padding-top:8px;">
<table border="0" cellpadding="0" cellspacing="1" style="border:#FFD39B 1px solid;">
<tr>
<td width="40" align="center" bgcolor="#FFFFFF">评价</td>
<td width="50" align="center" bgcolor="#FFF8DC">好评</td>
<td width="50" align="center" bgcolor="#FFF8DC">中评</td>
<td width="50" align="center" bgcolor="#FFF8DC">差评</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF"><span id="haoping_scor" class="chenghong2"><?php echo $e_haoping?></span>分</td>
<td align="center" bgcolor="#FFFAF0"><input type="radio" id="radio" name="haoping" class="hp" value="1" <?php if($e_haoping==1){echo 'checked="checked"';}?> disabled /></td>
<td align="center" bgcolor="#FFFAF0"><input type="radio" id="radio" name="haoping" class="hp" value="0" <?php if($e_haoping==0){echo 'checked="checked"';}?> disabled  /></td>
<td align="center" bgcolor="#FFFAF0"><input type="radio" id="radio" name="haoping" class="hp" value="-1" <?php if($e_haoping==-1){echo 'checked="checked"';}?> disabled  /></td>
</tr>
</table>
</td></tr>
<tr><td style="padding-left:5px;">
<div class="content" style="position:relative;">
<div class="pingji" style="line-height:32px;">
<?php
if(!empty($rating_class)){
	foreach($rating_class as $item){
?>
<li><dd><?php echo $item->title?></dd><dt id="dpStar<?php echo $item->id?>"><?php for($i=1;$i<=5;$i++){?><a href="javascript:void(0);" id="<?php echo $i?>">&nbsp;</a><?php }?>
<a class="scor" id="<?php echo $item->id?>"></a></dt></li>
<?php }}?>
</div>
<div class="clear"></div>
</div>

</td></tr>
<tr><td height="28" valign="bottom"><strong>评价内容：</strong><?php echo $e_note?></td></tr>
<?php }?>
</table>

<?php }else{?>
<form class="validform" method="post">
<input type="hidden" name="key" id="key" value="<?php echo $key?>" />
<input type="hidden" name="keyid" id="keyid" value="<?php echo $keyid?>" />
<input type="hidden" name="hp_scor" id="hp_scor" value="1"/>
<input type="hidden" name="scor" id="scor"/>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="5">

<?php if(!empty($r_user_links)&&!empty($r_content)){?>
<tr><td colspan="2" valign="bottom">
<?php echo $r_user_links?>&nbsp;&nbsp;订单信息：<?php echo $r_content?>
</td></tr>
<?php }?>

  <tr>
    <td colspan="2" valign="bottom" style="padding-top:8px;">
    <table border="0" cellpadding="0" cellspacing="1" style="border:#FFD39B 1px solid;">
      <tr>
        <td width="40" align="center" bgcolor="#FFFFFF">评价</td>
        <td width="50" align="center" bgcolor="#FFF8DC">好评</td>
        <td width="50" align="center" bgcolor="#FFF8DC">中评</td>
        <td width="50" align="center" bgcolor="#FFF8DC">差评</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><span id="haoping_scor" class="chenghong2">1</span>分</td>
        <td align="center" bgcolor="#FFFAF0"><input type="radio" id="haoping" name="haoping" class="hp haoping" value="1" checked="checked" /></td>
        <td align="center" bgcolor="#FFFAF0"><input type="radio" id="haoping" name="haoping" class="hp haoping" value="0" /></td>
        <td align="center" bgcolor="#FFFAF0"><input type="radio" id="haoping" name="haoping" class="hp haoping" value="-1" /></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2" style="padding-left:5px;">
<div class="content" style="position:relative;">
<div class="pingji" style="line-height:32px;">
<?php
if(!empty($rating_class)){
foreach($rating_class as $rs){
?><li><dd><?php echo $rs->title?></dd><dt id="dpStar<?php echo $rs->id?>"><?php for($i=1;$i<=5;$i++){?><a id="<?php echo $i?>">&nbsp;</a><?php }?><a class="scor"></a><input type="hidden" name="hiStar<?php echo $rs->id?>" id="hiStar<?php echo $rs->id?>" value="" /></dt></li><?php }}?>

</div>
<div class="clear"></div>
</div>
</td></tr>
<tr><td height="22" colspan="2" valign="bottom" style="padding-left:4px;">写点评价：</td></tr>
<tr><td colspan="2">
<textarea name="note" rows="3" id="note" style="width:99%; height:100px;" nullmsg="请填写评价内容!" errormsg="至少5个字,最多70个字!" datatype="*5-70" ></textarea>
</td></tr>
<tr><td width="90" style="color:#F00;" class="edit_box_save_but">
<input type="submit" class="save_but" value="" />
</td><td width="1014" style="color:#F90;">&nbsp;&nbsp;<span id="send_tip" class="red">&nbsp;</span></td></tr>
</table>
</form>
<?php }?>
