/* 绑定选择城市下拉 */

//绑定sel项
function selectTo(obj,data)
{
	if(data=="loading"){data='[{"val":"","title":"loading..."}]';}
	var data = eval(data);
	obj.html("");
	$.each(data,function(i,v){
	  var thisobj=$("<option>").text(v.title).val(v.val);
	  obj.append(thisobj); 
	  });
}

//obj 表示被操作对象,url 数据源
function JsonSel(obj,url)
{
	//加载
	selectTo(obj,"loading");
	//提交并返回数据
	$.ajax({
		   url:base_url+url,
		   type:'GET',
		   dataType:'json',
		   async:false,
		   success:function(data){ selectTo(obj,data); }
		 });
	obj.fadeOut(0).fadeIn(400);
	return obj.val();
}

$(function(){   
   //初始化,select解冻
   $("select#p_id").attr("disabled",false); 
   $("select#c_id").attr("disabled",false); 
   $("select#a_id").attr("disabled",false); 

   //切换省份时,城市跟随变化
   $("select#p_id").change(function(){
       var selid  = $(this).val();             //被选中省份ID
	   var selobj = $("select#c_id");  	       //被操作的对象,城市下拉
	   var selid2 = JsonSel(selobj,"places/sel_citys/"+selid); //返回select项的同时，返回第一项的id值
	   //同时选中地区
	   JsonSel($("select#a_id"),"places/sel_areas/"+selid2); //json提交,返回到select
     });
   
   //切换城市时,地区跟随变化
   $("select#c_id").change(function(){
       var selid  = $(this).val();             //被选中城市ID
	   var selobj = $("select#a_id");  	       //被操作的对象,区域下拉
	   JsonSel(selobj,"places/sel_areas/"+selid); //json提交,返回到select
     });
//====================================================================
   $("select#b_p_id").attr("disabled",false); 
   $("select#b_c_id").attr("disabled",false); 
   $("select#b_a_id").attr("disabled",false); 
   
   //切换省份时,城市跟随变化
   $("select#b_p_id").change(function(){
       var selid  = $(this).val();             //被选中省份ID
	   var selobj = $("select#b_c_id");  	       //被操作的对象,城市下拉
	   var selid2 = JsonSel(selobj,"places/sel_citys/"+selid); //返回select项的同时，返回第一项的id值
	   //同时选中地区
	   JsonSel($("select#b_a_id"),"places/sel_areas/"+selid2); //json提交,返回到select
     });
   
   //切换城市时,地区跟随变化
   $("select#b_c_id").change(function(){
       var selid  = $(this).val();             //被选中城市ID
	   var selobj = $("select#b_a_id");  	       //被操作的对象,区域下拉
	   JsonSel(selobj,"places/sel_areas/"+selid); //json提交,返回到select
     });

});

