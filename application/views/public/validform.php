<?php
/*
 * 表单
 */
if(!empty($formTO)){
  $tourl = $formTO->url;
  $backurl = $formTO->backurl;
  //$query = $formTO->query;
  if(!empty($tourl)){$tourl = site_url($tourl);}
  if(!empty($backurl)&&$backurl!=''&&$backurl!='null'){$backurl = site_url($backurl).reUrl('v=null');}
  //if(!empty($query)){ $backurl.= $query; }
if(!empty($formTO->editjs)){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" />
<script language="javascript" charset="utf-8" src="<?php echo $edit_url?>k/kindeditor.js"></script>
<?php }?>
<?php /*?><script type="text/javascript" src="<?php echo $js_url;?>validform/js/validform.js"></script><?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>mod_validform.js"></script>
<script language="javascript" type="text/javascript"> $(function(){formTO('<?php echo $tourl?>','<?php echo $backurl?>');}); </script>
<?php }?>