<?php $this->load->view('public/header'); ?>
<script>
$(function(){
  $('.my_left').fadeOut(0).delay(500).fadeIn(500);
  <?php if($page==='NULL'){?>
  $('#mark_load_txt').text('页面初始化失败!');
  <?php }elseif(!empty($page)){?>
  PageAjax('<?php echo $page;?>');
  <?php }?>
});
</script>