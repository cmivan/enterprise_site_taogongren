<?php $this->load->view('public/header');?>

<?php
//评分绑定
if($allow_comm){
	echo '<script language="javascript" type="text/javascript">';
	echo '$(function(){';
	echo "$('#common_case').load('".site_url('common/add/ca')."?id=".$id."&key=".case_hash($id)."');";
//	if(!empty($e_scorarr)){		 
//		foreach($e_scorarr as $item){
//			$item_id = $item['id'];
//			$item_scor = $item['scor'];
//			echo '$(".pingji dt#dpStar'.$item_id.'").removeClass().addClass("selectS'.$item_scor.'");';
//			if($item_scor!=0){
//				echo '$(".pingji dt#dpStar'.$item_id.'").find(".scor").html("<span class=chenghong2>'.$item_scor.'</span>分");';
//				}
//		}
//	}
	echo '});</script>';
  }
?>

</head><body><?php $this->load->view('public/top');?>
<div class="main_width"><div class="body_main"><div class="body_left"><div class="content_box"><div class="content"><div class="info_top uid" uid="<?php echo $user->id?>"><div class="left"><a href="<?php echo site_url("user/".$user->id)?>"><img src="<?php echo $this->User_Model->faceB($user->photoID)?>" width="95" height="122" /></a></div>
<div class="right"><div class="name"><?php echo $user->name?></div><div><?php echo $user->c_name?>&nbsp;<?php echo $user->a_name?></div><div><span>等级：<button id="ico_levels" class="level_1">&nbsp;</button></span></div><div><span class="haoping">好评率：<?php echo $haoping_sroc?></span></div><div id="team_buttom"><div class="team_tilte"><img src="<?php echo $img_url?>ico/cilun.gif" align="absmiddle" />&nbsp;<?php echo $nicetitle?>的团队 <button id="btu_team_arrow" class="btu_team_arrow_down">&nbsp;</button></div><div class="team_box"><?php if($team_but==0){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;暂未创建<br /><?php }elseif($team_but==1){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a target="_blank" href="<?php echo site_url("/user/".$Tid)?>" id="<?php echo $Tid?>"><?php echo $this->User_Model->name($Tid)?></a><br /><?php }elseif($team_but==2){?><img src="<?php echo $img_url?>ico/development.png" align="absmiddle"/>&nbsp;<a href="javascript:void(0);" id="<?php echo $user->id?>" class="cj_team">创建团队</a><br /><?php }?></div></div></div><div class="clear"></div></div><div class="info_edit"><div class="left"><?php echo $approves;?></div><div class="right" userid="<?php echo $user->id?>"><a href="javascript:void(0);" class="tip yz_buy" title="下单给他">&nbsp;</a><a href="javascript:void(0);" class="tip yz_favorites" title="放入收藏夹">&nbsp;</a><a href="javascript:void(0);" class="tip yz_friend" title="加他为好友">&nbsp;</a><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $user->qq?>&site=qq&menu=yes" class="tip yz_qq" title="和他QQ交谈">&nbsp;</a><a href="javascript:void(0);" class="tip send_msg" title="发送站内消息">&nbsp;</a></div><div class="clear"></div></div><div class="clear"></div></div></div><div class="content_box"><div class="title"><h1>个人介绍</h1><div class="clear"></div></div><div class="content" style="text-indent:20px;"><?php echo noHtml($user->note)?></div></div><div class="content_box"><div class="title"><h1>好友</h1><div class="clear"></div></div><div class="content"><div class="friends">
<?php if(!empty($friend1)){?><?php foreach($friend1 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->fuid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->fuid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>
<?php if(!empty($friend2)){?><?php foreach($friend2 as $rs){?><li><div class="dd"><a href="<?php echo site_url("user/".$rs->uid)?>" style=" float:left;width:50px;height:50px;overflow:hidden;"><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" width="50" /></a></div><div class="dl"><a target="_blank" href="<?php echo site_url("user/".$rs->uid)?>"><?php echo $rs->name?></a><br /><?php echo date("Y-m-d",strtotime($rs->addtime))?></div></li><?php }?><?php }?>
<div class="clear"></div>
</div><div class="clear"></div></div></div></div>
 <div class="body_right"><div class="content_box"><div class="title"><h1>案例展示</h1><div class="clear"></div></div><div class="content tipbox" style="padding-left:8px; padding-right:8px; width:auto; background-image:none;"><table border="0" cellpadding="0" cellspacing="6"><tr><td height="32" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr></tr><tr><td style="font-size:14px; color:#666;"><strong><?php echo $view->title?></strong>&nbsp;&nbsp;<span style="font-size:12px;color:#999;">( <?php echo $view->addtime?> )</span></td><td align="center">&nbsp;</td></tr></table></td></tr><tr><td height="520" valign="top"><div class="page_content" style=" padding-top:8px;width:580px; overflow:hidden; border-top:#FFE4C4 1px solid;"><?php echo $view->content?></div></td></tr>
<tr><td align="right" valign="top"><div style="border-top:#FFE4C4 1px solid; margin-bottom:8px;"></div>  
&nbsp;&nbsp;<a href="#">顶部</a>&nbsp;&nbsp;</td></tr>

<tr><td valign="top">
<div id="common_case"></div>
</td></tr>
</table>
</div></div></div><div class="clear"></div></div></div><?php $this->load->view('public/footer');?>