<?php
//-=================================================-
//-====  |       伊凡php建站系统 v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-04-02 11:00    | ====-
//-====  |       For    : 齐翔广告             | ====-
//-=================================================-
?>
<?php $this->load->view_system('header'); ?>
<style type="text/css">.left2right{background-color:#000;}</style>
<script language="javascript" type="application/javascript">
//导航项
$(function(){
  $(".left2right").live("click",function(){
	var thison = $("#frmTitle").css("display");
	//if(thison=="none"){$("#frmTitle").show(300);}else{$("#frmTitle").hide(300);}
	$("#frmTitle").toggle(300);
  }); 
});

if(self!=top){top.location=self.location;}
function switchSysBar(){
	if (document.all("frmTitle").style.display==""){
	document.all("frmTitle").style.display="none";
	}else{
	document.all("frmTitle").style.display="";
	}
}
</script>
</head>
<BODY leftMargin=0 topMargin=0 rightMargin=0 style="overflow:hidden">
<TABLE style="BORDER-COLLAPSE: collapse" cellSpacing=0 cellPadding=0 width="100%" height="100%" border=0>
<TR><TD height="77" valign="bottom" bgcolor="#FDCA01" id="logo">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="bottom"></td>
    <td width="586" valign="bottom"></td>
  </tr>
  <tr>
    <td width="185" style="font-family:Georgia, 'Times New Roman', Times, serif">&nbsp;</td>
    <td height="35" colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif"><span class="content">网站管理系统 v2.0</span></td>
    </tr>
</table>
</TD>
</TR>
<TR><TD height="5" bgcolor="#000000"></TD>
</TR>
<TR><TD>
<table width="100%" height="100%" border="0" align="center" cellPadding="0" cellSpacing="0">
<tr><td width="146" align="middle" vAlign="top" noWrap id="frmTitle">
<iframe frameborder="0" id="km_left" name="km_left" scrolling=auto src="<?php echo site_url($s_urls.'/system_left')?>" style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 146px; Z-INDEX: 2"></iframe></td>
<td class="left2right" style="cursor:pointer"><img src="/public/system_style/images/ico/meun_tab.gif" width="10" height="16"></td>
<td valign="top" style="WIDTH: 100%">
<iframe frameborder="0" id="main" name="km_main" scrolling="yes" src="<?php echo site_url($s_urls.'/system_info')?>" style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 100%; Z-INDEX: 1"></iframe>
</td></tr></table>
<script> if(parseInt(window.screen.width)<1024){switchSysBar();}</script>
</TD></TR></TABLE>
</body>
</html>