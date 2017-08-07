<?php $this->load->view('public/header'); ?>
<?php /*?>表单<?php */?>

<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_form.css" /><style>#TB_ajaxContent{ overflow:auto; overflow-x:hidden;}</style><script language="javascript" type="text/javascript"><?php /*?>订单操作-添加报价<?php */?>
$(function(){
	<?php /*?>返回管理列表页<?php */?>
    $(".BackBtu").click(function(){ window.location.href='<?php echo site_url($c_urls.'/view/'.$id)?><?php echo reUrl("")?>';});
	$("#num").blur(function(){okinputNum();allprice();});
	$("#r_price").blur(function(){okinputNum();allprice();});
	$("#c_price").blur(function(){okinputNum();allprice();});
	$("#p_note").blur(function(){okinputNum();allprice();});
	$("#units").blur(function(){okinputNum();allprice();});
	$("#project").blur(function(){okinputNum();allprice();});
	//$("#ok").click(function(){ return okinputNum(); });
	$("#search_pro").click(function(){
	tb_show('选择报价项目','<?php echo site_url($c_urls.'/project_industrys')?>?height=400&width=738',false);
	});
	allprice();
});<?php /*?>用于判断输入框内容是否符合要求(主要是数量，和单价)<?php */?>
function okinputNum(){
	var project=$("#project").val();
	var num    =$("#num").val();
	var units  =$("#units").val();
	var r_price=$("#r_price").val();
	var c_price=$("#c_price").val();
	var note   =$("#p_note").val();
	if(project==""){
		$("#backinfo").text("请填写项目名称！");
		return false;
	}else if(num!=parseInt(num)||num<=0){
		$("#backinfo").text("数量至少为1 ！");
		if(num<=0||num==""){num=1;}
		if(parseInt(num)!=parseInt(parseInt(num))){num=1;}
		$("#num").val(parseInt(num));
		return false;
	}else if(units==""){
		$("#backinfo").text("请填写单位！");
		return false;
	}else if(r_price!=parseInt(r_price)||r_price<=0){
		$("#backinfo").text("人工单价应为正整数！");
		if(r_price<0||r_price==""){r_price=0;}
		if(parseInt(r_price)!=parseInt(parseInt(r_price))){r_price=0;}
		$("#r_price").val(parseInt(r_price));
		return false;
	}else if(c_price!=parseInt(c_price)||c_price<0){
		$("#backinfo").text("材料单价应为非负整数！");
		if(c_price<0||c_price==""){c_price=0;}
		if(parseInt(c_price)!=parseInt(parseInt(c_price))){c_price=0;}
		$("#c_price").val(parseInt(c_price));
		return false;
	}else{
		$("#backinfo").text("");
		return true;
	}
}<?php /*?>更新总报价<?php */?>
function allprice(){
	var num    =$("#num").val();
	var r_price=$("#r_price").val();
	var c_price=$("#c_price").val();
	if((num==parseInt(num)&&num>0)&&(r_price==parseInt(r_price)&&r_price>=0)&&(c_price==parseInt(c_price)&&c_price>=0)){
		var thisprice=(parseInt(r_price)+parseInt(c_price))*parseInt(num);
		$("#allprice").val(thisprice);
	}else{
		$("#allprice").val("");	
	}
}</script>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div>
<div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"><?php
if(!empty($thisnav)){
	if(!empty($thisnav["nav"])){
	foreach($thisnav["nav"] as $nav){
?><a href="<?php echo site_url($c_url.$nav["link"])?>" <?php if($thisnav["on"]==$nav["link"]){echo "class=on";}?> ><?php echo $nav["title"]?></a><?php }}}?></div>
<div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?><div class="content"><br><table width="100%" cellpadding="0" cellspacing="0" class="edit_box" style="border:0"><?php
if(!empty($pro_view)){
   $rid  = $pro_view->retrieval_id;
?><tr><td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0"><tr><td align="left"><?php echo $this->User_Model->links($pro_view->uid)?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-decoration:underline">单号：<?php echo $pro_view->orderid?></span></td><td align="right">费用：<span class="chenghong"><?php echo $allprice?></span> 元&nbsp;&nbsp;</td><td width="150" align="left">下单时间：<?php echo dateYMD($pro_view->addtime)?></td><td width="72" align="center" class="diy_link_but"><!--<a href="javascript:void(0);" class="BackBtu">返回</a>--></td></tr></table>
<form class="validform" method="post"><table width="100%" border="0" cellpadding="5" cellspacing="1" class="edit_box" style="border:0;"><tr class="edit_item_frist"><td colspan="9" align="left"> &nbsp;添加工程项目报价</td></tr><tr class="editbox_title2"><td width="135" align="center">项目</td><td width="28" align="center">&nbsp;</td><td align="center">数量</td><td align="center">单位</td><td align="center">人工单价/元</td><td align="center">材料单价/元</td><td align="center">合计</td></tr><tr class="edit_item_tr"><td align="center"><input name="project" type="text" id="project" style="width:93%;text-align:center;" value="<?php echo $p_title?>"
 nullmsg="请填写内容" errormsg="请填写内容" datatype="*" /></td><td align="center"><span class="cm_btu"><a href="javascript:void(0);" class="buttom tip" title="点击选择相应的项目" id="search_pro">&nbsp;</a></span></td><td align="center"><input name="num" type="text" id="num" style="width:91%;text-align:center" value="<?php echo $p_num?>" size="10"
 nullmsg="请填写内容" errormsg="请填写内容" datatype="*" /></td><td align="center"><input name="units" type="text" id="units" style="width:91%;text-align:center" value="<?php echo $p_units?>" size="10"
 nullmsg="请填写内容" errormsg="请填写内容" datatype="*" /></td><td align="center"><input name="r_price" type="text" id="r_price" style="width:91%;text-align:center" value="<?php echo $p_r_price?>" size="10" nullmsg="请填写内容" errormsg="请填写内容" datatype="*" /></td><td align="center"><input name="c_price" type="text" id="c_price" style="width:91%;text-align:center" value="<?php echo $p_c_price?>" size="10" nullmsg="请填写内容" errormsg="请填写内容" datatype="*" /></td><td align="center"><input name="allprice" type="text" disabled="disabled" id="allprice" style="width:91%;border:0;background-color:#FFF;text-align:center" value="<?php echo $p_allprice?>" size="10" /></td></tr><tr class="editbox_title2"><td colspan="9" align="left" style="padding-left:6px;">施工工艺及材料说明</td></tr><tr class="edit_item_tr"><td colspan="9" align="center" style="padding-left:2px;" class="tip" title="系统提供施工工艺及材料说明<br>仅供参考,你可根据实际情况修改!"><textarea name="p_note" rows="5" id="p_note" style="width:99%;" nullmsg="请填写内容" errormsg="请填写内容" datatype="*" ><?php echo $p_note?></textarea></td></tr><tr><td colspan="9"><table border="0" cellpadding="0" cellspacing="1"><tr><td><div class="cm_btu"><input type="button" onClick="history.back(1);" class="buttom BackBtu" id="cancel" value="返回" /></div></td><td><div class="cm_btu"><input type="submit" class="buttom" id="ok" value="保存" /></div></td><td><span class="red" id="backinfo"></span><input type="hidden" name="id" value="<?php echo $id?>" /><input type="hidden" name="edit_id" value="<?php echo $p_editid?>" /><input type="hidden" name="go" value="yes" /></td></tr></table></td></tr></table></form>
</td></tr><?php }?></table></div></div></div></div><div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>