<div class="mainbox" box="content_box">
<?php /*?>投标页面操作导航<?php */?>
<div class="mainbox_nav"><?php echo Get_User_Nav($thisnav,$c_urls); ?></div>
<div class="mainbox_box">
<div class="content">
<table width="100%" border="0" cellpadding="4" cellspacing="1">
<tr class="edit_item_frist">
<td width="40" align="center">&nbsp;&nbsp;ID</td>
<td>&nbsp;&nbsp;标题</td>
<td width="85" align="center">发布日期</td>
<td width="75" align="center">参加人数</td>
<td width="40" align="center">状态</td>
<td width="100" align="center">操作</td>
</tr><tr align="center"><td colspan="7" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="center"><?php echo $rs->id?></td><td>
&nbsp;&nbsp;<a href="<?php echo site_url("/retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?>" target="_blank"><?php echo $rs->title?></a></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><?php echo $this->Retrieval_Model->election_num($rs->id);?></td><td align="center"><?php
$zt = $this->Retrieval_Model->ok_uid($rs->id);
if($zt==false){
   if(strtotime($rs->endtime)>dateDay24()){ echo "进行中"; }else{ echo "已过期";   }
}else{ echo "已中标"; }
?></td><td align="center">
<?php echo ajax_delurl('删除这项投标',$rs->id,$img_url.'my/ico/del.gif');?>
&nbsp;
<?php ajax_url('修改',$c_urls.'/edit/'.$rs->id);?>
</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="8" class="edit_item_none">暂无信息</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div>
<?php $this->paging->links(); ?><div class="clear"></div></div></div>