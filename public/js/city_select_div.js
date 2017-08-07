// JavaScript Document
var base_url=base_url;
if(base_url==''||base_url==null){base_url='/';}
$(function(){
  //取消焦点
  $("a").attr("hideFocus",true);
  $("input").attr("hideFocus",true);
  $("select").attr("hideFocus",true);
  //作用:点击城市选择框以外的地方 隐藏选择框
  $(document).click(function(e){
	 var e=e?e:window.event;
	 var tar=e.srcElement||e.target;
	 var class1=$(tar).attr("class");
	 var class2=$(tar).parent().parent().attr("class");
	 if(class1!="provinces_citys_box"&&class1!="provinces_citys"&&class1!="quyu"&&class1!="areas"&&class1!="quyu_box"&&class1!="provinces"&&class1!="item"&&class1!="item2"&&class1!="on"&&class2!="citys"){
		$(".provinces_citys_box").slideUp(300);
		$(".city_select #title").attr("class","off");
	 }		
  });
  //下拉选择城市
  $(".city_select #title").click(function(){
	  $(".provinces_citys_box").slideToggle(300);
	  if($(this).attr("class")=="on"){$(this).attr("class","off");}else{$(this).attr("class","on");}
  });
  //下拉选择城市--选择区域
  $(".quyu").find("a").click(function(){
	  //Qloading($(this).offset().left,$(this).offset().top);
	  var quyuid=$(this).attr("id");
	  $(".quyu").find("a").attr("class","");
	  $(this).attr("class","on");
	  $("#quyu_box").load(base_url+"places/sel_provinces/?regionid="+quyuid);
  });
  //下拉选择城市,返回城市名称及相应的区
  $("#quyu_box .areas").find("a").live('click',function(){
	  var cityid=$(this).attr("id");
	  $(".city_select").find(".citys").find("#title").find("a").html($(this).html());
	  $(".city_select").find(".citys").find("#title").find("a").attr("id",$(this).attr("id"));
	  $.ajax({type:'GET',url:base_url+'places/sel_provinces/?cityid='+cityid});
	  //可应用在不同页面
	  var url=searchkeys();
	  //转向页面
	  if(url!=""&&url!=null){ window.location.href='?'+url;return false; }
	  //收起选择框
	  $(".provinces_citys_box").fadeOut(200);
  });
});

//function Qloading(left,top)
//{
//	var obj = $('#quyuloading');
//	var size = obj.size();
//	$('body').css({"position":"relative"});
//	if(size<=0){ $('body').append('<div id="quyuloading" style="position:absolute;width:50px;height:50px;z-index:999">quyuloading</div>');
//	}else{
//		obj.css({"left":left,"top":top});
//	}
//}