<?php $this->load->view('public/header'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_form.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" /></head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>

<div class="my_right"><div class="mainbox" box="content_box"><?php /*?>个人信息页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>
<div class="mainbox_box "><form class="diy_form" method="post"><div class="yzpage_maintitle">帐号安全信息设置</div><table width="555" border="0" cellpadding="3" cellspacing="0" style="width:100%;"><tr class="edit_item_tr">
  <td width="16%" align="center"><?php echo yz_check($approve_sj,"绑定")?></td>
  <td width="15%" height="70" class="yzpage_title">绑定手机</td>
  <td width="58%" class="yzpage_note"> 绑定手机后，您即可享受手机服务，如手机登录、手机找回密码等。 </td>
  <td width="11%" align="center" class="yzpage_but">
  <a href="<?php echo site_url($c_url.'bind_mobile')?>?height=200&width=400&modal=false" title="重新绑定手机" class="thickbox">修改</a>
  </td></tr>
    <tr><td colspan="6" class="yzpage_line"></td></tr><tr class="edit_item_tr">
  <td align="center"><?php echo yz_check($approve_yx,"验证")?></td>
  <td height="70" class="yzpage_title">邮箱验证</td>
  <td class="yzpage_note">绑定邮箱后，可以方便找回密码。 </td>
  <td align="center" class="yzpage_but">
  <a href="<?php echo $c_url.'bind_email'?>?height=150&width=400&modal=false" title="验证邮箱" class="thickbox">验证</a>
  </td></tr>
    <tr><td colspan="6" class="yzpage_line"></td></tr><tr class="edit_item_tr">
  <td align="center"><?php echo yz_check($approve_mm,"修改")?></td>
  <td height="70" class="yzpage_title">登录密码</td>
  <td class="yzpage_note"> 建议设置一个包含数字和字母，并长度超过6位以上的密码。 </td>
  <td align="center" class="yzpage_but"><a href="<?php echo site_url($c_urls."/reset_password")?>" class="yz_mm">修改</a></td></tr>
    <tr><td colspan="6" class="yzpage_line"></td></tr> <tr class="edit_item_tr">
  <td align="center"><?php echo yz_check($approve_sm,"认证")?></td>
  <td height="70" class="yzpage_title">实名认证</td>
  <td class="yzpage_note"> 用于提升账号的安全性和信任级别。认证后的账号不能修改认证信息。 </td>
  <td align="center" class="yzpage_but"><a href="<?php echo site_url($c_urls."/approve_sm")?>" class="yz_sf">认证</a></td></tr>
<?php if(1==2){?><tr><td colspan="6" class="yzpage_line"></td></tr><tr class="edit_item_tr">
  <td align="center"><?php echo yz_check($approve_yhk)?></td>
  <td height="70" class="yzpage_title">银行卡认证</td>
  <td class="yzpage_note">认证后可以方便收款、提款、转账。</td>
  <td align="center" class="yzpage_but"><a href="javascript:void(0);" class="yz_yhk">认证</a></td></tr><?php }?>
  </table>
</form><br>
</div></div>
</div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>