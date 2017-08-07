<script type="text/javascript">
$(function(){
    <?php /*?>所有项的点击事件<?php */?>
	$(".click_box a").click(function(){
	   var isfor=$(this).parent().attr("isfor");
	   var thison=$(this).attr("class");
	   <?php /*?>for 多选<?php */?>
	   if(thison=="on"){
		   $(this).attr("class","");
		   $(this).find("input").attr("checked",false);
	   }else{
		   $(this).attr("class","on");
		   $(this).find("input").attr("checked",true);
	   }
	   <?php /*?>更新被选中的分工种<?php */?>
	   update_industry();
	});
});
<?php /*?>返回工种名称,或id :: t=0 返回id，t=1返回具体值<?php */?>
function update_industry(){
	var Ival = "";
	var I_helper = "";
	var ThisID = "";
	$(".click_box").find("a.on").each(function(){
	  ThisID = $(this).attr("id");
	  if(Ival==""){ Ival=Ival+ThisID; }else{ Ival=Ival + '_' + ThisID; }
	  if(I_helper==""){ I_helper = I_helper + ThisID; }else{ I_helper = I_helper + ThisID; }
	});
	$("#industryid").val(Ival); $("#i_helper").val(I_helper);
}
</script>
<style>#retrieval_box a{padding:2px;width:80px;border:#CCC 1px solid;margin-left:-1px;margin-bottom:-1px;display:inline-block;}
#retrieval_box input{border:0;}</style>