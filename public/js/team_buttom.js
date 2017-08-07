//创建团队加入团队按钮
$(function(){
  $("#team_buttom").hover(
	  function(){
		  $(this).find(".team_box").fadeIn(100);
		  $("#btu_team_arrow").attr('class','btu_team_arrow_up'); },
	  function(){
		  $(this).find(".team_box").fadeOut(100,function(){
				  $("#btu_team_arrow").attr('class','btu_team_arrow_down');
		  });
  });
});