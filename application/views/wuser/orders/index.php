<?php $this->load->view('public/header'); ?>

<script language="javascript" type="text/javascript"> 
function searchkeys(){
//<><> 辅助作用 <><> 
	}</script>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main">
<!--管理页面的框架分布--><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>

<div class="my_right">
<div class="mainbox" box="content_box">
<!--订单页面操作导航--><div class="mainbox_nav"><?php
if(!empty($thisnav)){
	if(!empty($thisnav["nav"])){
	foreach($thisnav["nav"] as $nav){
?><a href="<?php echo site_url($c_urls."/".$nav["link"])?>" <?php if($thisnav["on"]==$nav["link"]){echo "class=on";}?> ><?php echo $nav["title"]?></a><?php 
   }}}
?></div>
<div class="mainbox_box">
<div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="edit_box"><tr class="edit_box_frist">
  <td align="left">&nbsp;称呼</td>
  <td width="100" align="center">收藏时间</td>
  <td width="60" align="center">操作</td></tr><?php if(!empty($list)){?><?php foreach($list as $rs){?><tr><td align="left"><?php echo $this->User_Model->links($rs->fuid);?></td>
  <td align="center"><?php echo dateYMD($rs->addtime)?></td>
  <td align="center"><a href="<?php echo $rs->id?>" class="favorites_del_id"><img src="views/images/ico/del.png" width="10" height="10" title="取消收藏" /></a></td></tr><?php }}else{?><tr><td colspan="6" align="center">暂无信息</td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>
</div>

<div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>