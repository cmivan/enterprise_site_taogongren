<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" />
<script language="javascript" type="text/javascript"> 
$(function(){
  $(".recommend").click(function(){
	   var id=$(this).attr("id");
	   tb_show('推荐好友','<?php echo site_url($c_urls."/recommend_edit")?>?height=180&width=320&fuid='+id,false);
	  });
});
</script>
<div class="my_right">
<div class="mainbox" box="content_box">
<?php /*?>好友页面操作导航<?php */?>
<div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?></div>
<div class="mainbox_box">
<div class="content">
<table width="100%" border="0" cellpadding="5" cellspacing="1">
<tr class="edit_item_frist">
<td align="left">&nbsp;用户</td>
<td width="200" align="center">添加时间</td>
<td width="100" align="center">操作</td></tr>
<tr><td colspan="6" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="left">
&nbsp;<?php echo $this->User_Model->links($rs->fuid);?></td><td align="center"><?php echo dateYMD($rs->addtime)?></td>
<td align="center">
<?php echo ajax_delurl('取消好友','cmd=del&id='.$rs->id,$img_url.'my/ico/del.gif')?>
&nbsp;&nbsp;
<?php if( $this->Recommend_Model->is_Recommend($logid,$rs->fuid) ){?><img src="<?php echo $img_url?>ico/tick_circle.png" width="16" height="16" class="tip" title="已推荐" /><?php }else{?><a href="javascript:void(0);" cmd='null' id="<?php echo $rs->fuid?>" class="recommend tip" title="推荐后可以在个人主页上显示">推荐</a><?php }?>
&nbsp;&nbsp;<a href="<?php echo reUrl('cmd=black&id='.$rs->id,1)?>" class="tip" title="把他拉到黑名单，以免骚扰！">拉黑</a></td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="6" class="edit_item_none">暂无信息</td></tr><tr><td colspan="6" class="yzpage_line"></td></tr><?php }?></table>

<div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div>
</div></div></div>