<?php /*?>表单<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>mod_form.css" />
<script language="javascript" type="text/javascript">
$(function(){
//按钮解冻
$(".my_button").attr("disabled",false);
//充值验证
$(".chargebox").submit(function(){
	var p3_Amt=$(this).find("#p3_Amt").val();
	if(p3_Amt==""){
		$(this).find("#p3_Amt").fadeOut(200).fadeIn(200);
		$(this).find(".form_tip").text("请填写充值金额！");
		return false;
	}else if(p3_Amt!=parseInt(p3_Amt)){
		$(this).find("#p3_Amt").fadeOut(200).fadeIn(200);
		$(this).find(".form_tip").text("充值金额应该为整数！");
		return false;
	}else{
		//$(this).find(".form_tip").text("正在进行充值...");
		//return true;
		$(this).find(".form_tip").html("<br>由于第三方支付平台系统处于更新中<br>暂时不支持充值，敬请见谅！<br>...");
		return false;
	}
  });
//导航，充值淘工币和虚拟现金
$(".charge_nav a").click(function(){
	var thisindex=$(this).index();
	$(this).parent().find("a").attr("class","");
	$(this).attr("class","on");
	$(".charge_box form").fadeOut(0);
	$(".charge_box form").eq(thisindex).fadeIn(300);			  
	});
});
</script>
<style>
#p3_Amt{padding:6px;}
.my_button{padding:6px;background-color:#F60;color:#FFF;border:#CCC 1px solid;border-bottom:#333 1px solid;border-right:#333 1px solid;border-left:#C60 3px solid;border-right:#C60 3px solid;}
.charge_nav{margin-bottom:0;height:30px;line-height:29px;margin-bottom:-1px;}
.charge_nav a{float:left;padding-left:30px;padding-right:30px;background-color:#F3F3F3;color:#999;font-size:14px;border:#CCC 1px solid;border-bottom:0;margin-right:2px;}
.charge_nav a.on{float:left;padding-left:30px;padding-right:30px;background-color:#FFF;border:#CCC 1px solid;border-top:#333 1px solid;color:#000;border-bottom:0;margin-right:2px;}
.charge_nav a:hover{color:#000;text-decoration:none;}
.charge_box{border:#CCC 1px solid;background-color:#FFF;padding:15px;}
.tipbox{text-align:left;}
</style>
<div class="mainbox" box="content_box"><?php /*?>钱包页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?><div class="info">
&nbsp;&nbsp; 淘工币：<label class="chenghong"><?php echo $cost_T?></label> 个
&nbsp;&nbsp; 现金账户：<label class="chenghong"><?php echo $cost_S?></label> 元</div></div>
<div class="mainbox_box"><div class="content"><div style="padding:28px;"><div class="charge_nav"><a href="javascript:void(0);" cmd='null' class="on">充值淘工币</a><a href="javascript:void(0);" cmd='null'>充值虚拟现金</a></div><div class="charge_box"> <form method="post" action="<?php echo site_url($c_url.'yeepay/req')?>" class="chargebox" target="_blank"><div class="tipbox"><span class="chenghong">1</span>元 可以充值<span class="chenghong">1</span>个淘工币！充值后，可以用来查看工人手机信息等</div> <table border="0" cellpadding="5" cellspacing="1"><tr><td align="right" width="80">&nbsp;&nbsp;商户单号：</td><td align="left"><?php echo $order_no?><input name="p2_Order" type="hidden" id="p2_Order" value="<?php echo $order_no?>" size="30" /></td></tr><tr><td align="right">&nbsp;&nbsp;<span id="charge_title">我要充值：</span></td><td align="left"><input size="20" type="text" name="p3_Amt" id="p3_Amt" />
&nbsp;<span  id="charge_info">个淘工币</span> <span style="color:#FF0000;font-weight:100;">*</span></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品名称</td><td align="left"><input size="30" type="hidden" name="p5_Pid" id="p5_Pid"  value="淘工人在线充值"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品种类</td><td align="left"><input size="30" type="text" name="p6_Pcat" id="p6_Pcat"  value="T"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品描述</td><td align="left"><input size="30" type="text" name="p7_Pdesc" id="p7_Pdesc"  value="在线充值"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商户扩展信息</td><td align="left"><input size="30" type="text" name="pa_MP" id="pa_MP"  value="user:<?php echo $logid?>"/></td></tr><tr><td align="right">&nbsp;</td><td align="left"><input type="submit" value=" 前往支付页面 " class="my_button" disabled="disabled" /><span class="form_tip"></span></td></tr></table></form>

<form method="post" action="<?php echo site_url($c_url.'yeepay/req')?>" class="chargebox" target="_blank" style="display:none">    <table border="0" cellpadding="5" cellspacing="1"><tr><td align="right" width="80">&nbsp;&nbsp;商户单号：</td><td align="left"><?php echo $order_no?><input name="p2_Order" type="hidden" id="p2_Order" value="<?php echo $order_no?>" size="30" /></td></tr><tr><td align="right">&nbsp;&nbsp;<span id="charge_title">充值金额：</span></td><td align="left"><input size="20" type="text" name="p3_Amt" id="p3_Amt" />
&nbsp;<span  id="charge_info">元</span> <span style="color:#FF0000;font-weight:100;">*</span></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品名称</td><td align="left"><input size="30" type="hidden" name="p5_Pid" id="p5_Pid"  value="淘工人在线充值"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品种类</td><td align="left"><input size="30" type="text" name="p6_Pcat" id="p6_Pcat"  value="S"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商品描述</td><td align="left"><input size="30" type="text" name="p7_Pdesc" id="p7_Pdesc"  value="在线充值"/></td></tr><tr style="display:none;"><td align="right">&nbsp;&nbsp;商户扩展信息</td><td align="left"><input size="30" type="text" name="pa_MP" id="pa_MP"  value="user:<?php echo $logid?>"/></td></tr><tr><td align="right">&nbsp;</td><td align="left"><input type="submit" value=" 前往支付页面 " class="my_button" disabled="disabled" /><span class="form_tip"></span></td></tr></table></form></div></div><br><br><br><br><br><br><br><br>
<div class="clear"></div></div></div></div>