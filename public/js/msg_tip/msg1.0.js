/**
* @author cm.ivan
* 类似于微博新消息提示框
* 
*/
(function($){
		  $.fn.msgtip = function(options){
			 var $eml = $(this);
			 var opts = $.extend({},$.fn.msgtip.defaults,options);
			 var FixedFun = function(element){
				 var size_num = element.find('#WB_MSG_BOX').size();
				 if(parseInt(size_num)<1){
					 var boxHTML = '<div id="WB_MSG_BOX"><div class="wb_msg_main">';
					 boxHTML = boxHTML + '<table border="0" cellpadding="0" cellspacing="0" class="CP_w">';
					 boxHTML = boxHTML + '<thead><tr><th class="tLeft"><span></span></th><th class="tMid">';
					 boxHTML = boxHTML + '<span></span></th><th class="tRight"><span></span></th></tr></thead>';
					 boxHTML = boxHTML + '<tbody><tr><td class="tLeft"><span></span></td><td class="tMid">';
					 boxHTML = boxHTML + '<div class="yInfo">loading...</div>';
					 boxHTML = boxHTML + '</td><td class="tRight"><span></span></td></tr></tbody><tfoot><tr>';
					 boxHTML = boxHTML + '<td class="tLeft"><span></span></td><td class="tMid"><span></span></td>';
					 boxHTML = boxHTML + '<td class="tRight"><span></span></td></tr></tfoot></table>';
					 boxHTML = boxHTML + '<div class="close"><a href="javascript:void(0)" id="WB_close">&nbsp;</a></div>';
					 boxHTML = boxHTML + '<div class="arrow">&nbsp;</div></div></div>';
					 element.append(boxHTML);
					 element.find('#WB_MSG_BOX').fadeOut(0);
				  }

				  var top  = opts.top;  //距离顶部
				  var left = opts.left; //距离左侧
				  var msg  = opts.msg;  //消息内容
				  var url  = opts.url;  //通过url获取消息内容
				  var loop = opts.loop; //是否循环获取
				  if(top==''||top==null){ top = '22px';}
				  if(left==''||left==null){ left = '-10px';}
				  if(msg==''||msg==null){ msg = 'loading...';}
				  
				  //绑定属性
				  element.find('#wb_msg_main').css({"top":top,"left":left});
				  element.find("#WB_close").click(function(event){
										   element.find('#WB_MSG_BOX').fadeOut(300,function(){$(this).remove();});
										   element.attr('class','msg');
										   event.preventDefault();})
				  
				  if(url!=''&&url!=null){ loadmsg(url); }else{ showmsg(msg); }

				};

			 //获取msg  
			 var loadmsg = function(url){
				      var msgnum = parseInt($eml.find("a").find("b").text());
					  $.ajax({type:'GET',async:false,dataType:'json',url:url+'?T='+Math.random(),success:function(J){
						  var num = parseInt(J.num);
						  if(num!=0&&J.msg!=''&&msgnum!=num){
							  $eml.find("a").find("b").text(num);showmsg(J.msg);
						  }else if(num==0&&msgnum!=num){
							  $eml.find("a").find("b").text(num);
							  hidemsg();
						  }
					  }});
				 };
			 //返回显示
			 var showmsg = function(msg){
				  $eml.find('a').find('span').fadeIn(800);
				  //<><><><><><><><><><><><><><><><><><>
				  $eml.find('#WB_MSG_BOX').css({'line-height':'1px','height':'1px','width':'1px'});
				  $eml.find('#WB_MSG_BOX').find(".yInfo").html(msg);
				  $eml.attr('class','over');
				  $eml.find('#WB_MSG_BOX').fadeIn(300);
				 }
			 //返回显示
			 var hidemsg = function(){
				  $eml.find('a').find('span').fadeOut(800);
				  $eml.find('#WB_MSG_BOX').find(".yInfo").html('');
				  $eml.attr('class','');
				  $eml.find('#WB_MSG_BOX').fadeOut(300);
				 }  
			 //返回对象	 
			 return $eml.each(function(){ FixedFun($(this)); });
			}
			  
// default settings
//		  $.fn.msgtip.defaults = {
//				  top :'200px',
//				  left:'-10px',
//				  msg :'loading...'
//			  };

		  })(jQuery);
 
function loopmsg(url){ $('#msg_btu').msgtip({url:url}); }
