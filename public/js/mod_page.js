$(function(){
$(".recommendbox .tab_top").find("a").eq(0).attr("class","on");
$(".recommendbox").find(".tab").eq(0).css({display:"block"});
$(".recommendbox .tab_top").find("a").hover(
  function(){
  var thisindex=$(this).index();
  $(this).parent().find("a").attr("class","");
  $(this).attr("class","on");
  $(this).parent().parent().find(".tab_box").find(".tab").css({display:"none"});
  $(this).parent().parent().find(".tab_box").find(".tab").eq(thisindex).css({display:"block"});
  },function(){return false;});
});