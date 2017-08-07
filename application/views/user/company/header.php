<a name="company_top"></a>
<div class="ppc_box"><dl class="ppc_list2"><dt><span class="a_img">
<div class="a_logo"><img src="<?php echo $this->User_Model->faceB($photoID)?>" height="120" /></div>
<div class="clear"></div>
<span class="comtitle"><?php echo $name?></span></span>

<ul id="company_info">
<li class="title"><?php echo $truename?></li>
<?php
$note_adv = txt2arr($addr_adv);
if(!empty($note_adv)){
	foreach($note_adv as $nitem){
?>
<li class="lbg"><?php echo $nitem;?></li>
<?php }}?>
</ul>

<div class="tbox">
<span class="ntel" id="tel"><?php echo $cardnum?></span>

<span class="ntel" style="background:none;font-size:12px;color:#000;width:auto;">联系地址：<?php echo $address?></span>

</div></dt><dd>接听时间：<?php echo $cardnum2?></dd></dl></div>