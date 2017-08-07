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
		$mm   = "000828%3D%3D";   //密码
	
		if(is_num($mobile)&&$note!=''){
			
			$CI  = &get_instance();
			
			#判断数据库记录
			$sql = "select id,addtime from send_moblie where moblie=$mobile and ip='".ip()."'";
			$sql.= " and UNIX_TIMESTAMP(addtime)>=".time()."-".$sec." order by id desc LIMIT 1";
			if( $CI->db->query($sql)->num_rows()>0 ){
				//还在倒计时范围内，故直接返回 倒计时 或 1 
				if($T=='0'){
					$RS = $CI->db->query($sql)->row();
					$addsec = strtotime($RS->addtime) - (time() - $sec);
					/*重新记录超时时间*/
					echo '{"cmd":"dj","sec":"'.$addsec.'","info":"操作过于频繁,请稍后!'.$addsec.'"}';exit;
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
			$cutstr1= mb_convert_encoding($cutstr1,'gb2312','utf-8');
			$smsurl = 'http://webservice.10808.net/servlet/sms/smssend.xsms';
			$smsurl.= '?type=C&r_type=1';
			$smsurl.= '&name='.$zh.'&pwd='.$mm;
			$smsurl.= '&dst='.$mobile.'&msg='.$cutstr1;
			
			#正常做法:这里应该是需要解析返回的结果
			//$data = @file_get_contents($smsurl);
			//<root result="0" count="1" src="" key1="" key2="" key3="" key4=""/>
			$xml = simplexml_load_file($smsurl);
			if(!empty($xml))
			{
				$data = $xml['result'];
			}

			#发送下一段
			if(!empty($data)&&$data=='0'){
			   if(!empty($cutstr2)&&$cutstr2!=''){
				   return smsto($mobile,$cutstr2);
			   }else{
				   #保存发送记录
				   $sql = "INSERT INTO `send_moblie` (`moblie` ,`ip`,`addtime`) VALUES ('".$mobile."','".ip()."','".dateTime()."')";
				   $CI->db->query($sql);
				   return true;
			   }
			}else{
				echo '{"cmd":"n","info":"短信发送失败!"}';exit;
			}
		}
		return false;
	}
	
	//发送验证码类型限定
	function sms_code_type_check($key,$keyarr = 'yz|forget|reg|bind|tx')
	{
		$keyLimt = '_|'.$keyarr;
		if($key==''||strpos($keyLimt,$key,0)<=0){
			return false;
		}else{
			return true;
		}
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
	function emailto($fromname,$email,$subject,$message)
	{
		$sitename = "淘工人网";
		$username = "admin@taogongren.com";
		$password = "qx000828";
		@$jmail = new COM('JMail.Message') or die('Load Jmail False!');
		$jmail->silent = true;            //屏蔽例外错误
		$jmail->logging = true;           //启用邮件日志
		$jmail->fromname = $sitename;
		$jmail->from = $username;         //发件人
		$jmail->addrecipient($email);        //可添加多个邮件接受者
		$jmail->charset = "gb2312";    //否则中文会乱码
		$jmail->contenttype = "text/html"; //设置邮件格式为html格式
		$jmail->subject = $subject;
		$jmail->htmlbody = $message; 
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
/*	function emailto($fromname,$email,$subject,$message)
	{
		$CI = &get_instance();
		$CI->load->library('email');
		$config['protocol']  = 'smtp';
		$config['charset']   = 'utf-8';
		$config['smtp_host'] = 'smtp.qq.com';
		$config['smtp_user'] = 'admin@taogongren.com';
		$config['smtp_pass'] = 'qx000828';
		$config['smtp_port'] = '25';
		$config['mailtype']  = 'html';
		$config['_smtp_auth']= TRUE;
		$CI->email->initialize($config);
		$CI->email->from($config['smtp_user'],$fromname);
		$CI->email->to($email);
		$CI->email->subject($subject);
		$CI->email->message($message);
		$CI->email->send();
		//echo $CI->email->print_debugger();
		return true;
	} */
	
	
	
	
  

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
		$uid = is_num($uid);
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
		}else{
			return false;
		}
	} 
?>