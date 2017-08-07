<?php
//返回登录的状态和id
if( $logid != 0 && is_num($logid) ){ ?>
<table border="0" cellpadding="0" cellspacing="0"><tr><td>
<li><?php /*?>Hi,&nbsp;<?php */?><?php echo greetings();?></li>
<li><div class="top_nav_user_face"><?php echo $this->User_Model->links($logid)?></div></li>
<li class="line">&nbsp;</li>
<li id="msg_btu"><a href="<?php echo site_page2ajax('msg')?>" class="ico">短消息<span>(<b>0</b>)</span></a></li>
<li class="line">&nbsp;</li>
<li><a href="<?php echo site_url($c_url."center");?>">管理中心</a></li>
<li class="line">&nbsp;</li>
<li><a href="<?php echo site_url("action/logout");?>" class="user_login_out">退出</a></li>
</td></tr></table><?php /*?>获取该用户的最新消息<?php */?>
<?php }else{?>
<table border="0" cellpadding="0" cellspacing="0"><tr><td width="150">
欢迎来到淘工人网！<span style="display:none"><?php echo greetings();?></span></td><td>帐号：</td><td><input type="text" class="inputtext" id="username" /></td><td>密码：</td><td><input type="password" class="inputtext" id="password" /></td><td><button id="login_btu" class="cm_but btu_login_top">&nbsp;</button></td><td>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url("reg")?>">免费注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url("forget")?>" class="user_forget" title="忘记密码？">忘记密码？</a></td></tr></table>
<?php }?>