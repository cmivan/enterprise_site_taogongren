<?php

/**
 *站内信息
 *
 * @access: public
 * @author: mk.zgc
 * @use   : msgto 
 * @param : int，$uid ，发送用户id
 * @param : int，$to_uid ，收信用户id
 * @return: string，$note ，信息内容
 */
	function msgto($uid,$to_uid,$note)
	{
		$CI = &get_instance();
		$data['ip']      = $CI->input->ip_address();
		$data['content'] = $note;
		$data['uid']     = $uid;
		$data['suid']    = $to_uid;
		$mrs = $CI->db->insert('sendmsg',$data);
		if($mrs){return true;}else{return false;}	
	}

/**
 * 向手机发送信息
 *
 * @access: public
 * @author: mk.zgc
 * @use   : smsto 
 * @param : string，$mobile ，号码
 * @param : string，$note ，内容
 * @param : string，$T ，类型(是否倒计时)
 * @return: 0 成功,1失败
 */
	function smsto($mobile,$note,$T='0')
	{
		$sec  = 60;         //限制时间(秒)
		$num  = 66;         //字符分隔限制
		
		$zh   = "qxad2006"; //帐号
		//$mm   = "000828";   //密码
		$mm   = "000828==";   //密码
		
	
		if(is_num($mobile)&&$note!='')
		{
			
			$CI  = &get_instance();
			
			#判断数据库记录
			$CI->db->select('id,addtime');
			$CI->db->from('send_moblie');
			$CI->db->where('moblie',$mobile);
			$CI->db->where('ip',ip());
			$CI->db->where('( UNIX_TIMESTAMP(addtime) >= ('.time().'-'.$sec.') )');
			$CI->db->limit(1);
			$query = $CI->db->get();
			if( $query->num_rows()>0 )
			{
				//还在倒计时范围内，故直接返回 倒计时 或 1 
				if($T=='0')
				{
					$RS = $query->row();
					$addsec = strtotime($RS->addtime) - (time() - $sec);
					/*重新记录超时时间*/
					json_form_dj('操作过于频繁,请稍后再试!',$addsec);
				}
				return false;
			}

			$cutstr1 = $note;
			$nrNUM = strlen($note);
			#需要切分短信内容
			if($nrNUM>$num)
			{
			   $cutstr1 = cutstr($note,$num,0);
			   $cutstr2 = cutstr($note,$nrNUM-$num,$num);
			}
			
			#编码转换
			$cutstr1= mb_convert_encoding($cutstr1,'gbk','utf-8');
			$smsurl = 'http://webservice.10808.net/servlet/sms/smssend.xsms';
			$smsurl.= '?type=C&r_type=1';
			$smsurl.= '&name='.$zh.'&pwd='.$mm;
			$smsurl.= '&dst='.$mobile.'&msg='.$cutstr1;
			
			#正常做法:这里应该是需要解析返回的结果
			//$data = @file_get_contents($smsurl);
			//<root result="0" count="1" src="" key1="" key2="" key3="" key4=""/>
			$xml = @simplexml_load_file($smsurl);
			if(!empty($xml))
			{
				$data = $xml['result'];
			}

			#发送下一段
			if(!empty($data)&&$data=='0')
			{
			   if(!empty($cutstr2)&&$cutstr2!='')
			   {
				   return smsto($mobile,$cutstr2);
			   }
			   else
			   {
				   #保存发送记录
				   $CI->db->set('moblie',$mobile);
				   $CI->db->set('ip',ip());
				   $CI->db->set('addtime',dateTime());
				   $CI->db->insert('send_moblie');
				   return true;
			   }
			}
			else
			{
				json_form_no('短信发送失败!');
			}
		}
		return false;
	}
	
	//发送验证码类型限定
	function sms_code_type_check($key,$keyarr = 'yz|forget|reg|bind|tx')
	{
		$keyLimt = '@|'.$keyarr;
		if($key==''||strpos($keyLimt,$key,0)<=0)
		{
			return false;
		}
		return true;
	}









/**
 * 邮件发送函数
 *
 * @access: public
 * @author: mk.zgc
 * @use   : emailto 
 * @param : string，$fromname ，来自用户名
 * @param : string，$email ，邮箱
 * @param : string，$subject ，标题
 * @return: string，$message ，邮件信息
 */
/*	function emailto($fromname,$email,$subject,$message)
	{
		$charset = 'GBK';
		$charsetTO = 'UTF-8';
		//header('Content-Type:text/html;charset=' . $charset );
		$sitename = "淘工人网";
		$username = "admin@taogongren.com";
		$password = "qx000828";
		
		$fromname = mb_convert_encoding($fromname, $charset, $charsetTO);
		$sitename = mb_convert_encoding($sitename, $charset, $charsetTO);
		$email    = mb_convert_encoding($email, $charset, $charsetTO);
		$subject  = mb_convert_encoding($subject, $charset, $charsetTO);
		//message ='好，简单测试一下';
		$message  = mb_convert_encoding($message, $charset, $charsetTO);
		$jmail = new COM('JMail.Message') or die('Load Jmail False!');
		$jmail->silent = true;            //屏蔽例外错误
		//$jmail->logging = true;           //启用邮件日志
		$jmail->fromname = $sitename;
		$jmail->from = $username;         //发件人
		$jmail->addrecipient($email);        //可添加多个邮件接受者
		$jmail->charset = $charset ;    //否则中文会乱码
		$jmail->contenttype = "text/html"; //设置邮件格式为html格式
		$jmail->Encoding = $charset;
		$jmail->ContentTransferEncoding = $charset;
		//$jmail->Encoding ='base64';
		//$jmail->ContentTransferEncoding ='base64';
		$jmail->ISOEncodeHeaders = true;
		$jmail->subject = $subject;
		$jmail->htmlbody = $message;
		//$jmail->Body = $message;
		$jmail->Priority = 3;
		$jmail->mailServerUserName = $username; //发信邮件账号
		$jmail->mailServerPassword = $password; //账户的密码
		try{
			$email = @$jmail->Send('smtp.qq.com');
			if($email){return true;}else{return false;}
		} catch (Exception $e){
			//echo $e->getMessage();
			return false;
		}
		return true;
	}
*/

	function emailto($fromname,$email,$subject,$message)
	{
		$charset  = 'GBK';
		$charsetTO= 'UTF-8';
		$sitename = "淘工人网";
		$username = "admin@taogongren.com";
		$password = "qx000828";
		
		$fromname = mb_convert_encoding($fromname, $charset, $charsetTO);
		$sitename = mb_convert_encoding($sitename, $charset, $charsetTO);
		$email    = mb_convert_encoding($email, $charset, $charsetTO);
		$subject  = mb_convert_encoding($subject, $charset, $charsetTO);
		$message  = mb_convert_encoding($message, $charset, $charsetTO);
		
		$CI = &get_instance();
		$CI->load->library('email');
		$config['protocol']  = 'sendmail';
		//$config['protocol']  = 'smtp';

		$config['mailpath']  = "/usr/sbin/sendmail";
		$config['charset'] = $charset;
		//$config['wordwrap']  = FALSE;            

		$config['smtp_host'] = 'smtp.qq.com';
		$config['smtp_user'] = $username;
		$config['smtp_pass'] = $password;
		$config['smtp_port'] = '25';
		$config['mailtype']  = 'html';
		$config['_smtp_auth']= TRUE;
		$CI->email->initialize($config);
		$CI->email->from($config['smtp_user'],$sitename);
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);
		try{
			$email = @$CI->email->send();
			if($email)
			{
				return true;
			}
			return false;
		} catch (Exception $e){
			//echo $e->getMessage();
			return false;
		}
		return false;
	} 
	
	
	function hacking($tip='')
	{
		$hack = '';
		$hack.= '<div style=font-size:12px;>';
		$hack.= '<table>';
		$hack.= '<tr><td align=center colspan=2>网站安全操作记录</td></tr>';
		$hack.= '<tr><td align=right>用户IP:</td><td>' . ip() . '</td></tr>';
		$hack.= '<tr><td align=right>访问地址:</td><td>' . siteurl() . site_url(uri_string()) . reUrl('') . '</td></tr>';
		$hack.= '<tr><td align=right>操作简述:</td><td>' . $tip . '</td></tr>';
		$hack.= '</table>';
		$hack.= '</div>';
		emailto('hacking','cm.ivan@qq.com',$tip,$hack);
	}
	
  

/**
 * 系统发送订单消息发送
 *
 * @access: public
 * @author: mk.zgc
 * @use   : emailto 
 * @param : string，$uid ，用户id
 * @param : string，$msg ，信息内容
 * @return: string，$message ，邮件信息
 */
	function order_sendmsg($uid=0,$msg='')
	{
		$CI = &get_instance();
		$uid = get_num($uid);
		if($uid&&$msg!=''){
			#***** 加载发送辅助函数 ******
			$CI->load->helper('send');
			$mobile = $CI->User_Model->mobile($uid);
			#站内通知
			msgto(0,$uid,$msg.'。');
			if(strlen($mobile)==11){
				smsto($mobile,toText($msg).',详情请登录淘工人网!'); #手机通知
			}
			return true;
		}
		return false;
	} 
?>