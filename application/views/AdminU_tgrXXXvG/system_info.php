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
  <tr class="edit_item_frist">
    <td height="24" colspan="2" align="center">
     <font color="#666666">服务器系统信息</font>
    </td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">系统：</td>
    <td>&nbsp;<?php echo defined('PHP_OS')?PHP_OS:'未知';?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">版本：</td>
    <td>&nbsp;<?php echo $_SERVER["SERVER_SOFTWARE"];?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">语言环境：</td>
    <td>&nbsp;<?php echo $_SERVER["HTTP_ACCEPT_LANGUAGE"];?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">域名：</td>
    <td>&nbsp;<?php echo $_SERVER["SERVER_NAME"];?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">IP地址：</td>
    <td>&nbsp;<?php echo $_SERVER["SERVER_ADDR"];?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">端口：</td>
    <td>&nbsp;<?php echo $_SERVER["SERVER_PORT"];?></td>
  </tr>
<?php /*?>  <tr class="forumRow">
    <td width="120" align="right">根目录：</td>
    <td>&nbsp;<?php echo $_SERVER["DOCUMENT_ROOT"];?></td>
  </tr><?php */?>
  <tr class="forumRow">
    <td width="120" align="right">时区：</td>
    <td>&nbsp;<?php echo date("T",time())?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">时间：</td>
    <td>&nbsp;<?php echo date("Y年m月d日 H:i:s",time());?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">服务协议：</td>
    <td>&nbsp;<?php echo $_SERVER["SERVER_PROTOCOL"];?></td>
  </tr>
  <tr class="forumRow">
    <td width="120" align="right">剩余空间：</td>
    <td>&nbsp;<?php echo intval(diskfreespace(".")/(1024*1024)).'MB';?></td>
  </tr>

<?php /*?>  <tr class="forumRow">
    <td width="120" align="right">本文件路径：</td>
    <td>&nbsp;<?php echo $_SERVER["SCRIPT_FILENAME"]?></td>
  </tr><?php */?>
  
  <tr class="edit_item_frist">
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
