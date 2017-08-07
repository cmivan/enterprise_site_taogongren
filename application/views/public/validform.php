<?php
/*
 * 表单
 */
if(!empty($formTO->url)){
  $tourl = $formTO->url;
  $backurl = ( empty($formTO->backurl) || $formTO->backurl=='' ) ? '' : $formTO->backurl;
  //$query = $formTO->query;
  
  /* 如果参数 $backtitle 不为空，则在提交完成后，表单会以 tb_show 方式跳转*/
  $backtitle = (empty($formTO->backtitle) || $formTO->backtitle=='null') ? '' : $formTO->backtitle;
  /*
   提交成功后，页面跳转的方式
   $backtype = 0,普通的页面刷新
   $backtype = 1,tb_show 弹出框
   $backtype = 2,PageAjax页面加载
  */
  $backtype = (empty($formTO->backtype) || $formTO->backtype=='null') ? '' : $formTO->backtype;

  if(!empty($tourl)){$tourl = site_url($tourl);}

  if( $backurl!='null' )
  {
	  if( $backurl=='' && $backtype==0 )
	  {
		  $backurl = '';
	  }
	  elseif( $backurl=='' && $backtype==2 )
	  {
		  $backurl = reUrl('v=0',1);
	  }
	  else
	  {
		  $backurl = site_url($backurl).reUrl('v=null');
	  }  
  }

  //if(!empty($query)){ $backurl.= $query; }
if(!empty($formTO->editjs)){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $js_url;?>validform/css/css.css" />
<script language="javascript" charset="utf-8" src="<?php echo $edit_url?>k/kindeditor.js"></script>
<?php }?>
<?php /*?><script type="text/javascript" src="<?php echo $js_url;?>validform/js/validform.js"></script><?php */?>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>mod_validform.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>city_select_option.js"></script>
<script language="javascript" type="text/javascript"> $(function(){formTO('<?php echo $tourl?>','<?php echo $backurl?>','<?php echo $backtitle?>','<?php echo $backtype?>');}); </script>
<?php }?>