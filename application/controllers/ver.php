<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*升级记录*/
class Ver extends QT_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	//地址跳转（用于系统后台跳转中转,而不直接从后台进入前台页面
	//以免被统计器以访问来源方式记录后台地址信息
	function urlto()
	{
		//必须是后台登陆用户才可以使用本功能
		$power_system = $this->session->userdata('power_system');
		$url = $this->input->get('url');
		if($url!=''&&!empty($power_system))
		{
			//注销session
			if($url=='loginout')
			{
				$this->session->unset_userdata('power_system');
				redirect('/index', 'refresh');exit;
			}
			else
			{
				//跳转到指定位置
				redirect($url, 'refresh');exit;	
			}
		}
		show_404('/index' ,'log_error');
	}
	
	
	
	//案例验证
	function c($id=0)
	{
		$this->load->model('Case_Model');
		//检测id 不符合则返回404页面
		$id  = get_num($id,'404');
		$key = noHtml($this->input->get('key'));
		$r_key = case_hash($id);
		//验证key是否正确
		if($r_key!=$key)
		{
			show_404('/index' ,'log_error');
		}
		else
		{
			$this->session->set_userdata(array('allow_comm_id' => $id));
		}
		
		//id有效则根据案例id 返回相应的用户id
		$uid = $this->Case_Model->case_uid($id);
		$this->uid = get_num($uid,'404');
		
		/*获取用户信息*/
		$this->user=$this->User_Model->info($this->uid);
	    if(!empty($this->user))
		{
			$this->data["user"] = $this->user;
	    }
		else
		{
			show_404('/index' ,'log_error');
	    }
		
		redirect('user/cases/'.$id, 'location', 301);
	}
	
	//邀请注册链接
	function inviter($key='')
	{
		if(!empty($key)&&$key!='')
		{
			//用activity_inviter_url_resolve解析$key得uid
			$uid = activity_inviter_url_resolve($key);
			$uid = get_num($uid);
			if($uid)
			{
				//判断该用户是否存在
				$user_id = $this->User_Model->user_id($uid);
				if($user_id)
				{
					$this->session->set_userdata(array('inviterUID'=> $user_id));
					redirect('reg', 'location', 301);
				}
			}
		}
		json_echo('未找到相应的邀请人!');
		//backPage("邀请链接无效!","index.php",0);
	}
	

	//验证email
    function e()
    {
		$uid = $this->input->getnum('uid');
		$key = $this->input->get('key');
		$t = $this->input->get('t');
		if($uid!==false)
		{
			//获取用户信息
			$email = $this->User_Model->email($uid);
			if($email!='')
			{	//判断key是否合法
				$thisKey = key_hash($uid,$email,$t);
				if($thisKey!=$key)
				{
					json_echo('该链接无效!');
				}
				else
				{
					$data['approve_yx'] = 1;
					$this->db->where('id',$uid);
					$this->db->update('user',$data);
					json_echo('邮箱验证成功，谢谢!');
				}
			}
			else
			{
				json_echo('未找到相应的用户信息!');
			}
		}
		else
		{
			//json_echo('参数有误!');
		}

		
    }
	
	
	//QQ验证
	function qq()
	{
		$this->load->helper('file');
		//使用记录
		$data = '<><><><><><><><><><><><><><><><><><><><><>'.chr(10).chr(13);
		$data.= '使用时间：'.date("Y-m-d H:i:s").chr(10).chr(13);
		$data.= '使用IP：'.$_SERVER["REMOTE_ADDR"].chr(10).chr(13).chr(10).chr(13);
		
		$verpath = './public/alist';
		$verfile = $verpath.'/qqver.txt';
		
		$QQqun = $this->input->post('QQqun');
		$QQnum = $this->input->post('QQnum');
		$QQlist= $this->input->post('QQlist');
		if($QQqun!=''&&$QQnum!=''&&$QQlist!='')
		{
			//创建相应的文件
			$data = $QQlist;
			$newFile = $verpath.'\\qq\\'.$QQqun.'_'.$QQnum.'.txt';
			if(!write_file($newFile, $data, 'w+'))
			{
				write_file($newFile, $data);
			}
		}
		else
		{
			if(!write_file($verfile, $data, 'a+'))
			{
				write_file($verfile, $data);
			}
			json_echo('bate1.0_by_cmivan');
		}

	}
	
	
	
	//验证yeepay回调
	function yeepay_callback()
	{
		#	只有支付成功时易宝支付才会通知商户.
		##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.
		$this->load->helper('yeepay');
		$this->load->model('Records_temp_Model');
		
		$this->p1_MerId = $this->config->item('YeePay_Id');
		$this->p0_Cmd = $this->config->item('YeePay_Cmd');
		$this->p9_SAF = $this->config->item('YeePay_Saf');

		#	解析返回参数.
		$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
		#	判断返回签名是否正确（True/False）
		$bRet   = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
		#	以上代码和变量不需要修改.
		#	校验码正确.
		if($bRet)
		{
			#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
			#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.
			if($r1_Code=="1")
			{
			  //add by cm.ivan ，判断是否与临时表匹配
			  //select id,p2_Order,p3_Amt,p4_Cur,cost_type,uid from `rating_temp` where p3_Amt='".$r3_Amt."' and p4_Cur='".$r4_Cur."' and p2_Order='".$r6_Order."' and (cost_type='T' or cost_type='S') and ok=0 LIMIT 1";
			  $rs = $this->Records_temp_Model->record_temp_data($r3_Amt,$r4_Cur,$r6_Order);
			  if(!empty($rs))
			  {
				  $pid      =$rs->id;
				  $p2_Order =$rs->p2_Order;
				  $p3_Amt   =$rs->p3_Amt;
				  $p4_Cur   =$rs->p4_Cur;
				  $cost_type=$rs->cost_type;
				  $uid      =$rs->uid;
				  if(is_num($pid)&&is_num($uid))
				  {
					 //执行充值
					 //c_balance($uid,$p3_Amt,"在线充值,流水号：".$r2_TrxId,$cost_type);
					 //写入到充值表
					 $data = array(
						   'uid' => $uid,
						   'cost' => $p3_Amt,
						   'orderID' => $r2_TrxId,
						   'addtime' => dateTime(),
						   'ip' => ip()
						   );
					 $this->Records_temp_Model->record_charge_add($data);
					 
					 //删除临时数据
					 $this->Records_temp_Model->record_temp_del($pid);
					 //返回提示
					 json_echo('交易成功<br />在线支付页面返回');
				  }
				  else
				  {
					 json_echo('未找到相应的数据');
				  }
			  }
			  else
			  {
				  //不存在
				  json_echo('充值过期或者未提交相应的充值信息');
			  }
			  
			}
			elseif($r9_BType=="2")
			{
				#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
				json_echo('success!');
				json_echo('<br />交易成功,在线支付服务器返回');    			 
			}
		}
		else
		{
			json_echo('交易信息被篡!');
		}
	}




/*
 * Token后台快捷登录方式
 */
function system_token($key='',$id=0)
{
	$id = get_num($id);
	if($id&&$key!='')
	{
		//开始验证
		$this->load->model('System_user_Model');
		$rs = $this->System_user_Model->view($id);
		if(!empty($rs))
		{
			if(empty($rs->token_key)||$rs->token_key==0)
			{
				//未创建一键登录
				json_echo('未创建一键登录!');
			}
			else
			{
				$token_key = pass_token($rs->username.$rs->password.$rs->power.$rs->super);
				if($key!=$token_key)
				{
					//一键过期或错误
					json_echo('一键过期或错误!');
				}
				else
				{
					//验证通过,创建登录session ,记录所需的信息
					$data['logid'] = $rs->id;
					$data['super'] = $rs->super;
					$this->session->set_userdata("power_system",$data);
					redirect($this->config->item('s_url').'system_default', 'refresh');
					exit;
				}
			}
		}
	}
	//一键过期或错误(用户id错误)
	json_echo('一键过期或错误!');
}




/*
 * Token后台快捷登录方式,登录用户（可帮助用户编辑信息）
 * (12.1.11暂时废掉)
 */
/*function user_token($key='',$id=0)
{
	$id = get_num($id);
	if($id&&$key!=''){
		//开始验证
		$rs = $this->User_Model->info($id);
		if(!empty($rs)){
			$token_key = pass_token($rs->id.$rs->mobile.$rs->password.date('i',time()));
			if($key!=$token_key){
				//一键过期或错误
				json_echo('一键登录错误!');
			}else{
				
				if($rs->classid==0){
					$admin_url = $this->config->item("w_url");
				}else{
					$admin_url = $this->config->item("e_url");
				}
				 //login_nav 用于记录是否已经弹出登录向导(0未弹出,1已弹出)
				$logdata = array(
					  'logid' => $rs->id,
					  'username' => $rs->mobile,
					  'classid' => $rs->classid,
					  'uid' => $rs->uid,
					  'admin_url' => $admin_url,
					  'tasknav' => '1'
					  );
				//验证通过,创建登录session ,记录所需的信息
				$this->session->set_userdata($logdata);
				redirect($admin_url.'center', 'refresh'); exit;
			}
		}
	}
	json_echo('Err or Timeout!');
}*/




	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */