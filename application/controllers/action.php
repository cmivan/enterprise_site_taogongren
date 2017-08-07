<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
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
		   if(!empty($user)){
			   if($user->classid==0){
				   $admin_url = $this->config->item("w_url");
			   }else{
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
		   }else{
			   json_form_no("登录失败,帐号或密码有误!");
		   }
		}
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
 * 提交案例评论信息  (已经有common独立完成)
 */
/*	function case_comm()
	{
		$this->load->model('Evaluate_Model');
		$this->load->model('Rating_Model');
		$this->load->model('Case_Model');
		
		//获取用户信息
		$uid     = 0;
		$cid     = is_num($this->input->post('cid'));
		$haoping = is_num($this->input->post('hp_scor'));
		$note    = noHtml($this->input->post('note'));
		//$scor    = $this->input->post('scor');
json_form_no($haoping);
		//验证数据
		if($cid==false){ json_form_no('服务器繁忙,请稍后再试!'); }
		//是否显示评论框或者显示评论内容
		$allow_id = is_num($this->session->userdata('allow_comm_id'));
		if($allow_id==false||$allow_id!=$cid){ json_form_no('服务器繁忙,请稍后再试!'); }
		//判断该案例是否存在
		$row = $this->Case_Model->case_id($cid);
		if($row){ $ouid = $row->id; }else{ json_form_no('服务器繁忙,请稍后再试!'); }
		//限定评分范围
		$haoping = $this->Common_Model->rating_haoping($haoping);
		
		//返回星级评分数组
		$rating_class = $this->Rating_Model->rating_class(1); //rating_class
		$scorarr = $this->Common_Model->rating_scorarr($rating_class);

		if($note==''){ json_form_no('请填写你的评论!'); }


		//查看是否已经对该案例进行评论
		$row = $this->Evaluate_Model->evaluate_cases($cid,$ouid);
		if(!empty($row)){ json_form_no('该案例已经评分,请不要重复提交!'); }

		//写入评论及星级评分
	    $this->Common_Model->evaluate_add_cases($r_id,$this->logid,$r_uid,$note,$haoping,$scorarr);
		
		json_form_yes('你的评分已成功提交!');
	}*/
	
	

	
/**
 * 保存用户留言
 */
	function feedback()
	{
		$f_name    = noHtml($this->input->post("name"));
		$f_email   = noHtml($this->input->post("email"));
		$f_qq      = is_num($this->input->post("qq"));
		$f_content = noHtml($this->input->post("content"));
		
		if(empty($f_name)){
			json_form_no('请填写用户名!');
		}elseif(empty($f_email)){
			json_form_no('请填写用邮箱!');
		}elseif(empty($f_qq)){
			json_form_no('请填写联系QQ!');
		}elseif(empty($f_content)){
			json_form_no('请填写留言内容!');
		}else{
			//写入数据
			$sql = "insert into feedback (nicename,email,qq,content,uid,ip) values('$f_name','$f_email','$f_qq','$f_content','0','')";
			$this->db->query($sql);
			json_form_yes('留言成功!');
		}
		
	}
	


/**
 * 返回手机验证结果
 */
	function check_mobile($mobile=0)
	{
		$mobile = is_num($mobile);
		if($mobile==false){ $mobile = $this->input->post("param"); }
		if(empty($mobile)){ json_echo('请输入手机号码'); }
		elseif($this->is_reg_mobile($mobile)){ json_echo('y'); }
		else{ json_echo('该手机号已注册!如果你忘记了密码,请<a target="_blank" href="'.site_url("forget").'">找回密码！</a>'); }
	}


/**
 * 验证手机号是否已经被注册
 */
	function is_reg_mobile($mobile=0)
	{
		$mobile = is_num($mobile);
		if($mobile!=false&&strlen($mobile)==11){
		   $is_reg_num = $this->db->query("select mobile from `user` where mobile='$mobile'")->num_rows();
		   if($is_reg_num>0){return false;}else{return true;}
		}else{return false;}
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
		if(sms_code_type_check($type)==false){
			json_form_dj('参数有误!',1);
		}
		
		//生成验证码
		$code = rnd_no();
		$mobile = $this->input->get('mobile');
		
		//修改用户信息等验证，需要获取用户真实手机信息
		if(sms_code_type_check($type,'bind|tx')){
			$logid = is_num($this->data['logid']);
			if($logid){
				 //已登录,获取用户手机号
				$mobile = $this->User_Model->mobile($logid); 
			}else{
				//未登录或超时
				json_form_dj('登录超时!',1);
			}
		}
		
		//验证手机是否符合
		if(is_num($mobile)){
		   //生成验证码,并发送
		   $sendok = smsto($mobile,"你的验证码为：".$code." 【淘工人网】");
		   if($sendok){
			  /*用于验证\记录超时时间*/
			  $data = array(
							$type.'_mobile' => $mobile,
							$type.'_code' => $code,
							$type.'_timeout' => time() + $sec //设置超时时间
							);
			  $this->session->set_userdata($data);
			  json_form_dj('验证码已经发出,请'.$sec.'秒后再发送!',$sec);
		   }else{
			  json_form_dj('可能网络原因,验证码发送失败,请稍后再试!',1);
		   }
		 }else{
			  json_form_dj('输入的手机有误!',1);
		 }
	}


/**
 * 站内消息框
 */
	function send_msg($id=0)
	{
		/*获取用户信息*/
		$id  = is_num($id);
		$uid = is_num($this->logid);
		if($uid==false){
			json_form_box_login(); //先登录
		}elseif($id==false){
			json_form_alt("发送失败!");
		}elseif($uid==$id){
			#防止收藏自己
			json_form_alt("不能发送消息给自己哦!");
		}else{
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
		$suid = is_num($this->input->post("uid"));
		$note = noHtml($this->input->post("note"));
		if($suid==false){
			json_form_no('未找到收信人!');
		}elseif (empty($note)){
			json_form_no('请填写消息内容!');
		} else {
			//写入数据
			$data['ip']     = ip();
			$data['content']= $note;
			$data['suid']   = $suid;  //收信人
			$data['uid']    = $logid;
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
		$uid = is_num($uid);
		$logid = is_num($this->logid);
		$gid = is_num($this->input->get("gid"));
		
		if($logid==false){
			json_form_box_login(); //先登录
		}elseif($logid==$uid){
			#防止获取自己的手机
			json_form_alt("不能获取自己的手机号哦!");
		}elseif($uid!=false&&$gid!=false&&$go==0){
			#显示提示框
			json_echo('{"cmd":"g","gid":"'.$gid.'"}');
		}elseif($go==1){
		}else{ exit; }
	}




/**
 * 获取用户手机
 */
	function get_mobile_go($uid=0,$gid=1)
	{
		//加载模型
		$this->load->model('Records_Model');

	    $uid = is_num($uid);
	    $gid = is_num($gid);
	    $this->get_mobile($uid,1);
		if($gid!=false){
			//判断是否存在该工人
			$user_id = is_num($this->User_Model->user_id($uid));
			if($user_id){
				//判断是否已经查看
				$okNum = $this->db->query("select id from get_mobile where uid=".$this->logid." and gid=".$uid." LIMIT 1")->num_rows();
				if($okNum<=0){
					//扣除费用提示语
					$BC_tip = '查看&nbsp;'.$this->User_Model->links($uid).'&nbsp;的手机号码!';
					$BC_ok  = $this->Records_Model->balance_control($this->logid,'-1',$BC_tip,'T');
					if($BC_ok){
						$this->db->query("insert into get_mobile set uid=".$this->logid.",gid=".$uid.",ip='".ip()."'");
						$sj = $this->User_Model->mobile($uid);
						json_echo('{"cmd":"ok","info":"'.$sj.'","gid":"'.$gid.'"}');
					}else{
						json_form_alt("您的淘工币不足,请先充值!");
					}
				}else{
					json_form_alt("你已经可以查看!");
				} 
			}else{
				json_form_alt("未找到相应的用户!");
			}
		}else{
			json_form_alt("系统繁忙,请稍后再试!");
		}
	}
	
	

	
/**
 * 收藏用户
 */
	function favorite($uid=0)
	{
		/*获取用户信息*/
		$uid   = is_num($uid);
		$logid = is_num($this->logid);
		if($logid==false){
			json_form_box_login(); //先登录
		}elseif($uid==false){
			json_form_alt("无法收藏!");
		}elseif($logid==$uid){
			/*防止收藏自己*/
			json_form_alt("不能把自己放到收藏夹哦!");
		}else{
			/*读取用户信息*/
			$is_num = $this->db->query("select uid from `favorites` where fuid=".$uid." and uid=".$logid." LIMIT 1")->num_rows();
			if($is_num<=0){
				$this->db->query("INSERT INTO `favorites` (`uid` ,`fuid`)VALUES ('".$logid."', '".$uid."');");
				json_form_alt("成功放入收藏夹!");
			}else{
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
		$logid = is_num($logid);
		if($logid==false||$classid!=1){
			json_form_box_login('如果你是业主,请登录后操作!'); //先登录
		}else{
			json_echo('{"cmd":"url","url":"'.site_url($this->data['e_url'].'orders_select').'?to_uid='.$uid.'"}');
		}
	}	
	

	
/**
 * 添加好友
 */
	function friend($id=0)
	{
		/*获取用户信息*/
		$id = is_num($id);
		$uid = is_num($this->logid);
		if($uid==false){
			json_form_box_login(); //先登录
		}elseif($id==false){
			json_form_alt("无法加好友!");
		}elseif($uid==$id){
			json_form_alt("不能加自己为好友哦!");
		}else{
			/*读取用户信息*/
			$is_num = $this->db->query("select uid from `friends` where fuid=".$id." and uid=".$uid." LIMIT 1")->num_rows();
			if($is_num<=0){
				$this->db->query("INSERT INTO `friends` (`uid` ,`fuid`)VALUES ('".$uid."', '".$id."');");
				json_form_alt("已成功发送好友请求!");
			}else{
				json_form_alt("已发送好友请求!");
			}
		}
	}
	

/**
 * 获取技能信息(搜索页面的技能切换框)
 */
	function app_getskills($classid=0,$industryid=0,$hot=0)
	{
		//重组数组，并验证(防止非法注入)
		$show_str = "";
		$sqlArr   = "";
		$newIndustryArr="";
		
		if($industryid!=""){
		   $industryidarr=split("_",$industryid);
		   foreach($industryidarr as $item){
			  if(is_num($item)){
				 if($newIndustryArr==""){$newIndustryArr=$item;}else{$newIndustryArr.=",".$item;}
			  }
		   }
		}
		
		//生成相应的筛选条件
		if($classid==""){
		   $row=$this->db->query("select id from industry_class order by id asc LIMIT 1")->row();
		   $classid=$row->id;
		}elseif($classid=="no"){
		   $classid="";
		}
		//
		if(is_num($classid)&&$newIndustryArr!=""){
		  $sqlArr=" where industryid in ($newIndustryArr) and classid = $classid";
		}elseif(is_num($classid)){
		  $sqlArr=" where classid = $classid";
		}elseif($newIndustryArr!=""){
		  $sqlArr=" where industryid in ($newIndustryArr)";
		} 
		//
        if($hot==1){
           if($sqlArr==""){
			   $hot_sqlArr=" where industryid<>0";}else{$hot_sqlArr=$sqlArr." and industryid<>0";
			   }
           $csql = "select * from industry".$hot_sqlArr." order by stimes desc,title asc,id desc LIMIT 4"; 
		   $show_str.='<span style="padding-top:8px; padding-left:6px;padding-right:6px;float:left;"><img title="热门项目!" src="/public/images/ico/hot.gif" /></span>';
        }else{
	       $csql = "select * from industry".$sqlArr." order by title asc,id desc";	
		   $show_str='<a href="javascript:void(0);" id="no" class="on">不限</a>';  
        }
		//
		$row=$this->db->query($csql)->result();
		$show_skills="";
		foreach($row as $rs){
		  $show_skills.='<a href="javascript:void(0);" id="'.$rs->id.'">'.$rs->title.'</a>';
		}
		if($show_skills!=""){
		   $show_skills=$show_str.$show_skills;
		}
		$show_skills.='<div class="clear"></div>';
		
		json_echo($show_skills);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */