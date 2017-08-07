<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title><?php echo $seo['title']?></title>
<meta name="keywords" content="<?php echo $seo['keywords']?>" />
<meta name="description" content="<?php echo $seo['description']?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="cm.ivan@163.com"/>
<link rel="search" type="application/opensearchdescription+xml" href="http://ci.taogongren.com/public/plugins/opensearch.xml" title="淘工人" />
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" />

<?php $this->load->view('public/public_style'); ?>
<?php $this->load->view('public/validform'); ?>

<?php activity_login_task(); //用户登录后的向导框(提示用户进行资料补充和发布任务) ?>