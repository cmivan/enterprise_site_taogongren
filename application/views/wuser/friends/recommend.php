<?php $this->load->view('public/header'); ?>
<?php /*?>验证表单<?php */?>

<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" /><?php /*?>推荐好友<?php */?><script language="javascript" type="text/javascript">
$(function(){
  $(".recommend").click(function(){
	   var id=$(this).attr("id");
	   tb_show('推荐好友','<?php echo site_url($c_urls."/recommend_edit")?>?height=180&width=320&fuid='+id,false);
	  });
   });</script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="125" align="left" valign="top">用户</td>
  <td align="left">&nbsp;推荐理由</td><td width="120" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="left">
&nbsp;<?php echo $this->User_Model->links($rs->fuid);?></td><td>&nbsp;<?php echo $rs->note?></td><td align="center"><a href="<?php echo reUrl('del_id='.$rs->id)?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>
&nbsp;&nbsp;<a href="javascript:void(0);" id="<?php echo $rs->fuid?>" class="recommend">修改</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>