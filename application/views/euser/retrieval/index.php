<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>投标页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div><div class="mainbox_box"><div class="content"><table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="edit_item_frist">
  <td width="40" align="center">&nbsp;&nbsp;ID</td>
  <td>&nbsp;&nbsp;标题</td>
  <td width="85" align="center">发布日期</td>
  <td width="75" align="center">参加人数</td>
  <td width="40" align="center">状态</td>
  <td width="100" align="center">操作</td></tr><tr align="center"><td colspan="7" class="yzpage_line"></td></tr>
<?php if(!empty($list)){?><?php foreach($list as $rs){?><tr class="edit_item_tr"><td align="center"><?php echo $rs->id?></td><td>
&nbsp;&nbsp;<a href="<?php echo site_url("/retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?>" target="_blank"><?php echo $rs->title?></a></td><td align="center"><?php echo dateYMD($rs->addtime)?></td><td align="center"><?php echo $this->Retrieval_Model->election_num($rs->id);?></td><td align="center"><?php
$zt = $this->Retrieval_Model->ok_uid($rs->id);
if($zt==false){
   if(strtotime($rs->endtime)>dateDay24()){ echo "进行中"; }else{ echo "已过期";   }
}else{ echo "已中标"; }
?></td><td align="center"><a href="<?php echo site_url($c_urls.'/edit/'.$rs->id)?>">修改</a> &nbsp;<a href="<?php echo reUrl('del_id='.$rs->id)?>" class="del_id tip" title="删除该投标信息"><img src="<?php echo $img_url?>my/ico/del.gif" width="10" height="10" /></a></td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }}else{?><tr class="edit_item_tr"><td colspan="8" class="edit_item_none">暂无信息</td></tr><tr><td colspan="7" class="yzpage_line"></td></tr><?php }?></table><div class="clear"></div></div>
<?php $this->Paging->links(); ?><div class="clear"></div></div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>