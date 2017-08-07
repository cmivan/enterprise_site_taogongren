<div class="recommendbox">
<div class="tab_title">
<div class="ico"><button class="cm_but PHB_ico_1">&nbsp;</button></div>英雄榜</div>
<div class="tab_top">
<a href="javascript:void(0);">工人</a>
<a href="javascript:void(0);">团队</a>
</div>
<div class="clear"></div>
<div class="tab_box"><div class="tab"><?php foreach($user_yxb as $rs){?><li><dd><a target="_blank" href="<?php echo site_url("/user/".$rs->id)?>"><?php echo $rs->name?></a></dd><dt>揽活<span><?php echo $rs->counts?></span>次</dt></li><?php }?><div class="clear"></div></div>
<div class="tab"><?php foreach($team_yxb as $rs){?><li><dd><a target="_blank" href="<?php echo site_url("/user/".$rs->id)?>"><?php echo $rs->name?></a></dd><dt>揽活<span><?php echo $rs->counts?></span>次</dt></li><?php }?><div class="clear"></div></div>
</div><div class="clear"></div>
</div>