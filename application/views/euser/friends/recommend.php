<?php /*?>验证表单<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" />
<?php /*?>推荐好友<?php */?>
<script language="javascript" type="text/javascript">
$(function(){
  $(".recommend").click(function(){
	   var id=$(this).attr("id");
	   tb_show('推荐好友','<?php echo site_url($c_urls."/recommend_edit/1")?>?height=180&width=320&fuid='+id,false);
	  });
   });
</script>
<div class="mainbox" box="content_box"><?php /*?>好友页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="125" align="left" valign="top">用户</td>
  <td align="left">&nbsp;推荐理由</td>
  <td width="120" align="center">操作</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>

<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="left">
&nbsp;<?php echo $this->User_Model->links($rs->fuid);?></td><td>&nbsp;<?php echo $rs->note?></td>
<td align="center">
<?php echo ajax_delurl('取消推荐',$rs->id,$img_url.'my/ico/del.gif')?>
&nbsp;&nbsp;
<a href="javascript:void(0);" id="<?php echo $rs->fuid?>" cmd='null' class="recommend">修改</a>
</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr>
<?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>
<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div>