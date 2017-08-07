function formTO(url,backurl,backtitle,backtype)
{
  //返回地址
  if(backurl==null||backurl==''){ backurl=false; }
  if(backtype==null||backtype==''){ backtype=0; }

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
				if(backurl!='null'){
					if( backtype == 0 ){
						if(backurl==false){window.location.reload();}else{window.location.href=backurl;}
					}else if( backtype == 1 ){
						tb_show(backtitle,backurl,false);
					}else if( backtype == 2 ){
						PageAjax(backurl); tb_remove();
					}
				}
			  },5000);
		  }else if(data.cmd=="n"){
			  setTimeout(function(){$.Hidemsg();},5000);
		  }
	  }
  });
  bindtip(); //生成表单后再绑定提示
}