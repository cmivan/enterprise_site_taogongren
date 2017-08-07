<?php $this->load->view('public/header');?>
<script type="text/javascript">
var url = "<?php echo site_url("company/verifycode")?>?";
$(function(){ $('#verifycode').attr('src',url); });
function reload_vcode(v)
{
	var rand = Math.random();
	url += rand;v.src = url;
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>company/company_style.css" />

<?php if(1==2){?>
<link rel="stylesheet" href="<?php echo $css_url?>screen.css" type="text/css" media="screen" /><?php /*?>LightBox v2.0<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>mod_lightbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="../../../../public/style/mod_star.css" /><?php /*?>评级打分<?php */?>
<link rel="stylesheet" type="text/css" href="../../../../public/style/fullcalendar/fullcalendar.css" /><?php /*?>排期日历<?php */?>
<link rel="stylesheet" type="text/css" href="../../../../public/style/company/company_style.css" />
<?php }?>
 
</head>
<body><?php $this->load->view('public/top');?>
<div class="main_width">
<div class="body_main" style="padding:0; margin:0;">
<div id="wrapper">
<div class="box"></div>
<div class="content"><div class="block_type_120">
<div class="nei bd newbd" style="padding-top:30px; padding-bottom:30px; padding-left:50px;">
<table width="95%" border="0">
<tr><td width="280" style="width:491px; height:448px; background-image:url(<?php echo $img_url;?>company/login_gb.jpg); background-position:right; background-repeat:no-repeat;">

</td><td valign="top">
<form class="validform" method="post" style="padding-left:40px; padding-top:90px;">
<table border="0" cellpadding="0" cellspacing="6">
  <tr><td width="65">&nbsp;</td><td>&nbsp;</td>
  </tr>
  <tr><td align="right">企业帐号：</td>
    <td><input class="inputxt" type="text" name="user" id="user" nullmsg="请输入企业帐号!" errormsg="请输入企业帐号!" datatype="*" ></td>
    </tr>
  <tr><td align="right">管理密码：</td>
  <td><input class="inputxt" type="password" name="pass" id="pass" nullmsg="请输入管理密码!" errormsg="请输入管理密码!" datatype="*" ></td>
  </tr>
  <tr>
    <td align="right">验证码：</td>
  <td>
  <input name="code" type="text" class="inputxt" id="code" style="width:105px;" maxlength="4"
 nullmsg="验证码不能为空!" errormsg="请输入正确的验证码!" datatype="p" />
  <a href="javascript:void(0);"><img src="" alt="点击刷新" name="verifycode" height="23" border="0" align="absmiddle" class="code_img" id="verifycode" onClick="reload_vcode(this)" /></a>
  </td>
  </tr>
  <tr><td>&nbsp;</td><td><button class="cm_but btu_login" type="submit">&nbsp;</button></td>
    </tr>
</table>
</form>
</td></tr></table>

</div></div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>