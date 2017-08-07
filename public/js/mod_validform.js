function formTO(url,backurl)
{
  //返回地址
  if(backurl==null||backurl==''){ backurl=false; }
  //绑定表单
  $(".validform").validform({
	  tiptype:2,  //postonce:true, //防止重复提交
	  ajaxurl:url,
	  callback:function(data){
		  //这里执行回调操作;
		  if(data.cmd=="y"){
			  //公用方法关闭信息提示框
			  setTimeout(function(){
				$.Hidemsg();
				//当null时,不刷新
				if(backurl!='null'){ if(backurl==false){window.location.reload();}else{window.location.href=backurl;} }
			  },1500);
		  }else if(data.cmd=="n"){
			  setTimeout(function(){$.Hidemsg();},1800);
		  }
	  }
  });
  bindtip(); //生成表单后再绑定提示
}