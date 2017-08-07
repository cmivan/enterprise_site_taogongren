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
<script type="text/javascript">
$(function(){
  $(".item_yes").click(function(){
		  var thisid =$(this).parent().attr("id");
		  if(parseInt(thisid)==thisid){
			  if(confirm("确定该用户提交的实名认证信息【有效】吗？")){
				  window.location.href="?cmd=yes&id="+thisid+"&page=<?php echo $page?>";return true;}}							 
		  });
  $(".item_no").click(function(){
		  var thisid = $(this).parent().attr("id");
		  if(parseInt(thisid)==thisid){
			  if(confirm("确定该用户提交的实名认证信息【无效】吗？"))
			  {
				  var errtip = window.prompt("请留下该身份证不符合要求的原因：","");
				  if(errtip==''||errtip==null){
					  alert('操作无效,未填写原因!');return false;
				  }else{
					  window.location.href="?cmd=no&id="+thisid+"&errtip="+errtip+"&page=<?php echo $page?>";return true; 
				  }
			  }
		  }							 
	});
});
</script>
</head>
<body>
<table width="100%" border="0" align=center cellpadding=1 cellspacing=1 class="forum2 forumtop">
<tr class="forumRaw">
<td width="100%" align="center"><?php echo $table_title;?> 管理列表</td><td width="54%" align="right">
<?php $this->load->view_system('public_search'); ?>
</td></tr></table>
<form name="edit" method="post" action="">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
<tr class="forumRaw edit_item_frist">
<td width="40" align="center">编号</td>
<td align="center">&nbsp;用户</td>
<td align="center">真是姓名</td>
<td align="center">身份证正反面</td>
<td align="center">身份证号</td>
<td align="center">提交日期</td>
<td align="center">认证状态</td>
<td align="center" class="edit_box_edit_td">操作</td>
</tr>
	  
	  
<?php
if(!empty($list)){
	$delnum = 0;
	foreach($list as $rs){
		$delnum++;
		
		$photo1 = str_replace('views/tg_pic_up/','',$rs->photo);
		$photo2 = str_replace('views/tg_pic_up/','',$rs->photo2);
		
		$this->db->query("update yz_sm set photo='".$photo1."', photo2='".$photo2."' where id=".$rs->id);
		
		$approve1 = img_approve($rs->photo);
		$approve2 = img_approve($rs->photo2);
?> 
<tr class="forumRow">
<td align="center"><?php echo $rs->id;?></td>
<td>&nbsp;<?php echo $this->User_Model->links($rs->uid)?></td>
<td align="center"><?php echo $rs->truename?></td>
<td align="center">
<a href="<?php echo $approve1?>" title="<?php echo $rs->truename?> 的身份证正面，身份证号：<?php echo $rs->sfz?>" class="thickbox">
<img src="<?php echo $approve1?>" alt="Plant 1" width="20" height="20" border="0" class="sm_pic" /></a>
<a href="<?php echo $approve2?>" title="<?php echo $rs->truename?> 的身份证反面，身份证号：<?php echo $rs->sfz?>" class="thickbox">
<img src="<?php echo $approve2?>" alt="Plant 2" width="20" height="20" border="0" class="sm_pic" /></a>
</td>
<td align="center"><?php echo $rs->sfz?></td>
<td align="center"><?php echo dateHi($rs->addtime)?></td>
<td align="center"><?php echo $this->Introduce_Model->stats($rs->ok)?></td>
<td align="center" id="<?php echo $rs->id?>">

<?php if($rs->ok==0){?>
<a href="javascript:void(0);" class="item_no" title="该用户提交的身份证信息无效，则点击此处审核不通过！"><span class="red">&times;</span>不通过</a>&nbsp;&nbsp;
<a href="javascript:void(0);" class="item_yes" title="该用户提交的身份证信息有效，则点击此处审核通过！"><span class="green">&radic;</span>通过</a>
<?php }else{ echo '<strong title="已对该信息审核">-</strong>'; }?>
</td></tr>

<?php if($rs->errtip!=''){?>
<tr class="forumRow"><td align="center"><strong class="red"><?php echo $rs->id;?></strong></td>
<td colspan="7" align="left" class="td_padding"><strong class="red">未通过原因：</strong><span class="red"><?php echo $rs->errtip?></span></td></tr>
<?php }?>

<?php }?>
<tr class="forumRaw">
<td colspan="12">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="forum3">
  <tr>
  <td width="10">&nbsp;</td>
  <td><?php $this->Paging->links(); ?></td>
  </tr></table>
</TD></tr>
<?php }else{?>
<tr class="forumRow">
  <td height="50" colspan="12" align="center">暂无相应内容!</td>
  </tr>
<?php }?>
</table>
</form>
</body>
</html>