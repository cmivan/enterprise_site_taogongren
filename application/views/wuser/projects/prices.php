<script language="javascript" type="text/javascript"> 
$(function(){
	$(".item_edit").click(function(){
		var pro_id=$(this).parent().attr("id");
		tb_show('管理技能报价','<?php echo site_url($c_urls."/edit")?>?height=175&width=420&pro_id='+pro_id,false);
		});
	});
</script>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="5" cellspacing="1"><tr class="edit_item_frist">
  <td width="200">&nbsp;&nbsp;工种项目</td>
  <td width="70" align="center">报价(元)</td>
  <td align="left">&nbsp;报价说明</td>
  <td width="100" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?>
<?php foreach($list as $rs){?>
<tr class="edit_item_tr"><td>&nbsp;&nbsp;<?php echo $rs->title?></td>
<td align="center" class="chenghong"><?php echo $rs->price?></td>
<td align="left">&nbsp;<?php echo $rs->note?></td><td align="center" id="<?php echo $rs->id?>">
<?php echo ajax_delurl('取消这项报价',$rs->id,$img_url.'my/ico/del.gif');?>
&nbsp;&nbsp;<a href="javascript:void(0);" cmd='null' class="item_edit">编辑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?>
</table>


<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>