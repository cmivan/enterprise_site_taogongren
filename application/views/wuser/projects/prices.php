<?php $this->load->view('public/header'); ?>
<script language="javascript" type="text/javascript"> 
$(function(){
	$(".item_edit").click(function(){
		var pro_id=$(this).parent().attr("id");
		tb_show('管理技能报价','<?php echo site_url($c_urls."/edit")?>?height=175&width=420&pro_id='+pro_id,false);
		});
	});</script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td width="200">&nbsp;&nbsp;工种项目</td>
  <td width="70" align="center">报价(元)</td>
  <td align="left">&nbsp;报价说明</td>
  <td width="100" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td>&nbsp;&nbsp;<?php echo $rs->title?></td><td align="center" class="chenghong"><?php echo $rs->price?></td><td align="left">&nbsp;<?php echo $rs->note?></td><td align="center" id="<?php echo $rs->id?>"><a href="?del_id=<?php echo $rs->id?>" class="item_del"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?>
</table>


<div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div>
</div></div>
</div>
<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>