<script type="text/javascript">var base_url='<?php echo base_url()?>';var img_url ='<?php echo $img_url?>';var js_url='<?php echo $js_url?>';</script>
<?php /*?>Jq 框架<?php */?>
<script type="text/javascript" src="<?php echo $jq_url?>"></script>
<script type="text/javascript" src="<?php echo $js_url;?>validform/js/validform.js"></script>
<?php /*?>全局样式及JS<?php */?>
<link type="text/css" rel="stylesheet" href='<?php echo site_url_css('global_v1/css/css')?>?p=<?php echo site_arrfile($cssfiles);?>'/>
<script type="text/javascript" src='<?php echo site_url_js('global_v1/js/js')?>?p=<?php echo site_arrfile($jsfiles);?>'></script>
<?php /*?>获取最新消息<?php */?>
<script type="text/javascript" src="<?php echo $js_url?>msg_tip/msg1.0.js"></script>
<script> $(function(){ window.setInterval('loopmsg("<?php echo site_url('global_v1/new_msg_tip')?>")',2500); }); </script>
<?php /*?>提示tips.开始<?php */?>
<script type="text/javascript" src="<?php echo $js_url?>poshytip/poshytip.js"></script>
<script type="text/javascript">
function bindtip()
{
  $('.tip').poshytip({
	className: '<?php echo $plugins['poshytip']?>',
	showTimeout: 1,
	alignTo: 'target',
	alignX: 'center',
	offsetY: 8,
	allowTipHover: true
  });
}
<?php /*辅助作用*/
if(empty($searchkeys)){?>
function searchkeys(){return false;}
<?php }?>
</script>