<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends QT_Controller {

	function __construct()
	{
		parent::__construct();
	}

	
/**
 * 检查用户登录
 */
	function login()
	{
		#验证登录信息
		#$config['encryption_key'] = ' ';
		#将该键设置不为空,才可以调用session
		$username = noHtml($this->input->post("username"));
		$password = $this->input->post("password");
		if(!empty($username)&&!empty($password))
		{
	 	   $user = $this->User_Model->user_login($username,$password); //登录验证
	 	   //返回状态
		   if(!empty($user))
		   {
			   if($user->classid==0)
			   {
				   $admin_url = $this->config->item("w_url");
			   }
			   else
			   {
				   $admin_url = $this->config->item("e_url");
			   }
			   //login_nav 用于记录是否已经弹出登录向导(0未弹出,1已弹出)
			   $logdata = array(
					'logid'    => $user->id,
					'username' => $username,
					'classid'  => $user->classid,
					'uid'  => $user->uid,
					'admin_url' => $admin_url,
					'tasknav' => '0'
					);
			   $this->session->set_userdata($logdata);
		   	   json_form_yes("登录成功!");
		   }
		   json_form_alt("登录失败,帐号或密码有误!");
		}
		json_form_alt("请填写帐号或密码!");
	}
	
	
	
/**
 * 用户退出
 */
	function logout()
	{
		//清除登录的session
	    $logdata = array('logid' => '','username' => '','classid' => '','tasknav' => '');
		$this->session->unset_userdata($logdata);
		//跳转到主页
		redirect('index', 'location', 301);
	}


	
/**
 * 保存用户留言
 */
	function feedback()
	{
		$name    = noHtml($this->input->post("name"));
		$email   = noHtml($this->input->post("email"));
		$qq      = $this->input->postnum("qq");
		$content = noHtml($this->input->post("content"));
		
		if(empty($name))
		{
			json_form_no('请填写用户名!');
		}
		elseif(empty($email))
		{
			json_form_no('请填写用邮箱!');
		}
		elseif(empty($qq))
		{
			json_form_no('请填写联系QQ!');
		}
		elseif(empty($content))
		{
			json_form_no('请填写留言内容!');
		}
		else
		{
			$this->load->model('Feedback_Model');
			$data = array(
               'nicename' => $name ,
               'email' => $email ,
               'qq' => $qq ,
               'content' => $content ,
               'uid' => 0 ,
               'ip' => ip()
			   );
			$this->Feedback_Model->add($data);
			json_form_yes('留言成功!');
		}
		
	}
	


/**
 * 返回手机验证结果
 */
	function check_mobile($mobile=0)
	{
		if(is_num($mobile)==false)
		{
			$mobile = $this->input->post("param");
		}
		$back = '';
		if(is_num($mobile)==false)
		{
			$back = '请输入手机号码';
		}
		elseif($this->is_reg_mobile($mobile))
		{
			$back = 'y';
		}
		else
		{
			$back = '该手机号已注册!如果你忘记了密码,';
			$back.= '请<a target="_blank" href="'.site_url("forget").'">找回密码!</a>';
		}
		json_echo($back);
	}


/**
 * 验证手机号是否已经被注册
 */
	function is_reg_mobile($mobile=0)
	{
		if(is_num($mobile) && strlen($mobile)==11)
		{
			$is_reg_num = $this->User_Model->is_reg_mobile($mobile);
			if($is_reg_num<=0)
			{
				return true;
			}
		}
		return false;
	}


	
/**
 * 发送手机消息
 */
	function send_mobile($type='')
	{
		$sec = 60 ; //短信超时限制(秒)
		//加载
		$this->load->helper('send');
		
		//判断发送的类型是否符合
		if(sms_code_type_check($type)==false)
		{
			json_form_dj('参数有误!',1);
		}
		
		//生成验证码
		$code = rnd_no();
		$mobile = $this->input->get('mobile');
		
		//修改用户信息等验证，需要获取用户真实手机信息
		if(sms_code_type_check($type,'bind|tx'))
		{
			$logid = get_num($this->data['logid']);
			if($logid==false)
			{
				json_form_dj('未登录或登录超时!',1);
			}
			//已登录,获取用户手机号
			$mobile = $this->User_Model->mobile($logid); 
		}
		
		//验证手机是否符合
		if(is_num($mobile))
		{
			//生成验证码,并发送
			$sendok = smsto($mobile,"你的验证码为：".$code." 【淘工人网】");
			if($sendok)
			{
				/*用于验证 记录超时时间*/
				$data = array(
				     $type.'_mobile' => $mobile,
					 $type.'_code' => $code,
					 $type.'_timeout' => time() + $sec //设置超时时间
					 );
			    $this->session->set_userdata($data);
			    json_form_dj('验证码已经发出,请'.$sec.'秒后再发送!',$sec);
			}
			else
			{
				json_form_dj('可能网络原因,验证码发送失败,请稍后再试!',1);
			}
		 }
		 else
		 {
			  json_form_dj('输入的手机有误!',1);
		 }
	}


/**
 * 站内消息框
 */
	function send_msg($id=0)
	{
		/*获取用户信息*/
		$id  = get_num($id);
		$uid = get_num($this->logid);
		if($uid==false)
		{
			json_form_box_login(); //先登录
		}
		elseif($id==false)
		{
			json_form_alt("发送失败!");
		}
		elseif($uid==$id)
		{
			#防止收藏自己
			json_form_alt("不能发送消息给自己哦!");
		}
		else
		{
			#显示消息发送框
			json_form_box('发送站内消息',site_url('page/box_sendmsg').'?height=140&width=340&uid='.$id);
		}
	}
	
/**
 * 保存站内消息
 */
	function send_msg_save()
	{
		/*获取用户信息*/
		$logid = $this->logid;
		$suid = $this->input->postnum("uid");
		$note = noHtml($this->input->post("note"));
		if($suid==false)
		{
			json_form_no('未找到收信人!');
		}
		elseif(empty($note))
		{
			json_form_no('请填写消息内容!');
		}
		else
		{
			//写入数据
			$data['ip'] = ip();
			$data['content'] = $note;
			$data['suid'] = $suid;  //收信人
			$data['uid'] = $logid;
			$this->db->insert('sendmsg',$data);
			json_form_no('站内消息发送成功!');
		}	
	}
	


	
/**
 * 获取用户手机
 * $go=0 表示验证，$go=1表示验证并获取手机
 */
	function get_mobile($uid=0,$go=0)
	{
		/*获取用户信息*/
		$uid = get_num($uid);
		$logid = get_num($this->logid);
		$gid = $this->input->getnum("gid");
		if($logid==false)
		{
			//先登录
			json_form_box_login();
		}
		elseif($logid==$uid)
		{
			//防止获取自己的手机
			json_form_alt("不能获取自己的手机号哦!");
		}
		elseif($uid!=false&&$gid!=false&&$go==0)
		{
			//显示提示框
			json_echo('{"cmd":"g","gid":"'.$gid.'"}');
		}
		elseif($go==1)
		{
			
		}
		
	}




/**
 * 获取用户手机
 */
	function get_mobile_go($uid=0,$gid=1)
	{
		//加载模型
		$this->load->model('Records_Model');
		$this->load->model('GetMobile_Model');
		
	    $this->get_mobile($uid,1);
	    $gid = get_num($gid);
		if( $gid != false )
		{
			//判断是否存在该工人
			$user_id = get_num($this->User_Model->user_id($uid));
			if( $user_id )
			{
				//判断是否已经查看
				if( $this->GetMobile_Model->is_getok($this->logid,$uid) == false )
				{
					//扣除费用提示语
					$BC_tip = '查看&nbsp;'.$this->User_Model->links($uid).'&nbsp;的手机号码!';
					$BC_ok = $this->Records_Model->balance_control($this->logid,'-1',$BC_tip,'T');
					if( $BC_ok )
					{
						$mobile = $this->User_Model->mobile($uid);
						if( is_num($mobile) )
						{
							$data = array(
							      'uid' => $this->logid ,
							      'gid' => $uid ,
							      'ip' => ip()
							      );
							$this->GetMobile_Model->add($data);
							json_echo('{"cmd":"ok","info":"'.$mobile.'","gid":"'.$gid.'"}');
						}
						json_form_alt("服务器繁忙!");
					}
					json_form_alt("您的淘工币不足,请先充值!");
				}
				json_form_alt("你已经可以查看!");
			}
			json_form_alt("未找到相应的用户!");
		}
		json_form_alt("系统繁忙,请稍后再试!");
	}
	
	

	
/**
 * 收藏用户
 */
	function favorite($uid=0)
	{
		/*获取用户信息*/
		$uid   = get_num($uid);
		$logid = get_num($this->logid);
		if($logid==false)
		{
			json_form_box_login(); //先登录
		}
		elseif($uid==false)
		{
			json_form_alt("无法收藏!");
		}
		elseif($logid==$uid)
		{
			/*防止收藏自己*/
			json_form_alt("不能把自己放到收藏夹哦!");
		}
		else
		{
			$this->load->model('Favorites_Model');
			if( $this->Favorites_Model->add_one($logid,$uid) )
			{
				json_form_alt("成功放入收藏夹!");
			}
			else
			{
				json_form_alt("已在你的收藏夹!");
			}
		}
	}



	
/**
 * 雇佣用户
 */
	function orderto($uid=0)
	{
		$logid = $this->session->userdata('logid');
		$classid = $this->session->userdata('classid');
		$logid = get_num($logid);
		if($logid==false||$classid!=1)
		{
			json_form_box_login('如果你是业主,请登录后操作!'); //先登录
		}
		else
		{
			$thisurl = site_page2ajax( 'orders_select/index/' . $uid );
			json_echo('{"cmd":"url","url":"'.$thisurl.'"}');
		}
	}	
	

	
/**
 * 添加好友
 */
	function friend($uid=0)
	{
		/*获取用户信息*/
		$uid = get_num($uid);
		$logid = get_num($this->logid);
		if($logid==false)
		{
			json_form_box_login();
		}
		elseif($uid==false)
		{
			json_form_alt("无法加好友!");
		}
		elseif($logid==$uid)
		{
			json_form_alt("不能加自己为好友哦!");
		}
		else
		{
			$this->load->model('Friends_Model');
			if( $this->Friends_Model->add_one($logid,$uid) )
			{
				json_form_alt("成功发送好友请求!");
			}
			else
			{
				json_form_alt("已发送好友请求!");
			}
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */