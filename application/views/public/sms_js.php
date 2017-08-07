$(function(){
   <?php if($is_send){ /*?>绑定倒计时<?php */ ?>
   var newdate = new Date();
   newdate.setTime(<?php echo $timeout*1000?>);
   var s_date  = newdate;
   $('#send_sms').CRcountDown({startDate:s_date,callBack:re_button}).css('color','');
   <?php
      }
	  
   if(!empty($mobile)){ echo "$('#mobile').val('".$mobile."');"; }
   /*?>获取手机验证码<?php */
   ?>
   $('#send_sms a').live('click',function(){
      var mobile=$('#mobile').val();
      if(mobile==''||mobile==null){
         alert('请填写手机号码!'); $('#mobile').focus();
      }else if(mobile!=parseInt(mobile)||mobile.length!=11){
         alert('请填写正确的手机号码!'); $('#mobile').focus();
      }else{
         $('#send_sms').html('正发送验证码...');
         <?php /*?>提交并返回数据<?php */?>
         $.ajax({
             url:'<?php echo site_url('action/send_mobile/'.$type)?>?mobile=' + mobile + '&T='+Math.random(),
             type:'GET',dataType:'json',
             success:function(J){
                 switch(J.cmd)
                 {
                     case "no":
                        break
                     case "dj": dj_time(J.sec); //倒计时
                        break
                     case "re": re_button(); //已发送
                        break
                     default: re_button();
                 }
                 alert(J.info);
             }
         });
      }
  });
});

function re_button(){
	 $('#send_sms').html('<a href="javascript:void(0);">重新获取</a>');
	}
function dj_time(dj){
	 if(parseInt(dj)!=dj){dj = 60;}
     var d_sec   = 1000*parseInt(dj);
     var now     = new Date();
     var nows    = now.getTime()+parseInt(d_sec);
     var newdate = new Date();
     newdate.setTime(nows);
     var s_date  = newdate;
     $('#send_sms').CRcountDown({startDate:s_date,callBack:re_button}).css('color','');
	}