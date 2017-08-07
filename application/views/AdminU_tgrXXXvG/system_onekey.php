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
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
  <tr class="edit_item_frist"><td height="24" align="center">获取一键登录</td></tr>
  <tr class="forumRow">
    <td height="220" align="left" valign="top">
    <style>ul,li{list-style:decimal;list-style-type:decimal;}</style>
    <div style="padding:30px;margin:auto; width:310px;">
    <ul>
    <li>当前日期：<?php echo date('Y年 m月 d日',time());?></li>
    <li>生成的 <strong class="red">一键登录链接</strong> 只能在当月 (即 <?php echo date('m月份',time());?>) 使用</li>
    <li style="text-decoration:underline">不要在公共电脑使用一键登录链接</li>
    <?php if(!empty($token_time)&&!empty($token_key1)){?>
    <li>上次创建：<?php echo date('Y年 m月 d日 H:i:s',strtotime($token_time));?></li>
    <li>若需要取消上次生成的链接，请点击下面的 <strong class="red">注销一键</strong> 按钮</li>
    <?php }?>
    </ul>
    
<div style="padding-top:6px; text-align:left; margin-left:-18px; position:absolute;">
<table width="200" border="0" cellpadding="0" cellspacing="0">

<?php if(!empty($token_time)&&$token_key!=0){?>
	<?php if(date('Ym',strtotime($token_time))==date('Ym',time())){?>
        <tr><td>
        <form class="validform" method="post" action="?action=go">
        <input type="submit" value="&nbsp;&nbsp;注销一键&nbsp;&nbsp;">
        <input type="hidden" name="cmd" id="cmd" value="0"></form></td><td>
        <form class="validform" method="post" action="?action=go">
        <input type="submit" value="&nbsp;&nbsp;重新生成一键登录链接，并下载&nbsp;&nbsp;">
        <input type="hidden" name="cmd" id="cmd" value="1"></form>
        </td></tr>
    <?php }else{?>
        <tr><td>
        <form class="validform" method="post" action="?action=go">
        <input type="submit" value="&nbsp;&nbsp;注销一键(已过期)&nbsp;&nbsp;">
        <input type="hidden" name="cmd" id="cmd" value="0"></form></td><td>
        <form class="validform" method="post" action="?action=go">
        <input type="submit" value="&nbsp;&nbsp;生成一键登录链接，并下载&nbsp;&nbsp;">
        <input type="hidden" name="cmd" id="cmd" value="1"></form>
        </td></tr>
    <?php }?>
<?php }else{?>
<tr><td colspan="2" align="center">
<form class="validform" method="post" action="?action=go">
<input type="submit" value="&nbsp;&nbsp;生成一键登录链接，并下载&nbsp;&nbsp;">
<input type="hidden" name="cmd" id="cmd" value="1"></form></td></tr>
<?php }?>
  
  
<?php if(!empty($tip)){?><tr><td colspan="2" class="red">提示：<?php echo $tip?></td></tr><?php }?>
</table>

    </div></div>
</td></tr>
<tr class="edit_item_frist"><td align="center">&nbsp;</td></tr>
</table>
</body>
</html>
