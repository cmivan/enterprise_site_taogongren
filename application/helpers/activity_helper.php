<?php
#活动辅助函数

/**
 * 平台开放,允许不需要邀请好友可以直接创佳团队
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: string 
 */
function activity_sys_inviter($uid)
{
	//数组形式指定ID用户允许直接创建团队
	$least_num = 3;
	$arruid = "|5407|5408|5409|5410|5411|5412|5413|5420|5395|";
	$arruid = "|".$arruid;
	if(is_numeric($uid)&&$uid!=''){
		$inviter_num = activity_inviter_num($uid);//要求加入的人数
		$activity_team_created = activity_team_created($uid);    //是否已经创建
		if((is_numeric($inviter_num)&&$inviter_num>=$least_num)||$activity_team_created||strpos($arruid,"|".$uid."|",0)>0)
		{return true;}else{return false;}
	}else{
		return false;
	}
}



/**
 * 获取总的邀请人数
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: int 
 */
function activity_inviter_num($uid)
{
	$CI = &get_instance();
    $rownum = $CI->db->query("select id from `user` where inviterID=".$uid)->num_rows();
    return $rownum;
}



/**
 * 获取该用户是否已经开通团队
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_team_created($uid)
{
	$CI = &get_instance();
    $rownum = $CI->db->query("select id from `user` where uid=".$uid." and classid=2")->num_rows();
	if($rownum<=0){return false;}else{return true;}
}



/**
 * 完善个人信息而赠送工币
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_userok_2gift($uid)
{
	$isok = activity_create2gift($uid);
	if($isok){ json_form_alt("<活动赠送>已成功送出,谢谢你的参与!"); }

	$CI = &get_instance();
	$info = $CI->User_Model->info($uid);
	if(!empty($info)){
		$user_ok = true;
		if($info->mobile==''){$user_ok = false;}
		if($info->name==''){$user_ok = false;}
		if($info->sex==''){$user_ok = false;}
		if(is_num($info->photoID)==false){$user_ok = false;}
		if(is_num($info->entry_age)==false){$user_ok = false;}
		if(is_num($info->qq)==false){$user_ok = false;}
		if(is_num($info->p_id)==false){$user_ok = false;}
		if(is_num($info->c_id)==false){$user_ok = false;}
		if($info->birthday==''){$user_ok = false;}
		if($info->email==''){$user_ok = false;}
		if($info->address==''){$user_ok = false;}
		if($info->addr_adv==''){$user_ok = false;}
		if($info->note==''){$user_ok = false;}
		$ip = $CI->input->ip_address();
		//团队信息完成ok,则赠送
		if($user_ok){
			#***** 费用模块 ******
			$CI->load->model('Records_Model');
			$balances = $CI->Records_Model->balance_control($uid,"10","<活动赠送>恭喜你!完善个人信息并获得系统赠送!","T");
			if($balances){
				$CI->db->query("INSERT INTO `user_gift_ok` (`uid` ,`ip` ,`ok` ,`utype`) VALUES ('".$uid."' ,'".$ip."' ,'1' ,'1')");
				echo '{"cmd":"activity.ok","info":"恭喜你!你已成功领取10个淘工币!"}';
			}else{
				json_form_alt("系统繁忙!请稍候再试!");
			}
		}else{
			json_form_alt("请确定个人信息已经完善!");
		}
	}else{
		json_form_alt("系统繁忙!请稍候再试!");
	}
}





/**
 * 完善团队信息而赠送工币
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_teamok_2gift($uid)
{
	$isok = activity_create2gift($uid);
	if($isok){ json_form_alt("<活动赠送>已成功送出,谢谢你的参与!"); }

	$CI = &get_instance();
	$team_info = $CI->User_Model->info($uid);
	if(!empty($team_info)){
		$team_ok = true;
		if($team_info->name==''){$team_ok = false;}
		if(is_num($team_info->photoID)==false){$team_ok = false;}
		if(is_num($team_info->p_id)==false){$team_ok = false;}
		if(is_num($team_info->c_id)==false){$team_ok = false;}
		if($team_info->address==''){$team_ok = false;}
		if($team_info->note==''){$team_ok = false;}
		if($team_info->team_ckbj==''){$team_ok = false;}
		if($team_info->team_fwxm==''){$team_ok = false;}
		if($team_info->team_fwdq==''){$team_ok = false;}
		$ip = $CI->input->ip_address();
		//团队信息完成ok,则赠送
		if($team_ok){
			#***** 费用模块 ******
			$CI->load->model('Records_Model');
			$balances = $CI->Records_Model->balance_control($uid,"5","<活动赠送>恭喜你!完善团队信息并获得系统赠送!","T");
			if($balances){
				$CI->db->query("INSERT INTO `user_gift_ok` (`uid` ,`ip` ,`ok` ,`utype`) VALUES ('".$uid."' ,'".$ip."' ,'1' ,'1')");
				echo '{"cmd":"activity.ok","info":"恭喜你!你已成功领取5个淘工币!"}';
			}else{
				json_form_alt("系统繁忙!请稍候再试!");
			}
		}else{
			json_form_alt("请确定团队信息已经完善!");
		}
	}else{
		json_form_alt("请确定您已经创建团队!");
	}
}





/**
 * 是否创建团队而赠送工币
 * 活动期间使用--- (add:11-3-9)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_create2gift($uid)
{
	$CI = &get_instance();
    $rownum = $CI->db->query("select id from user_gift_ok where uid=".$uid." and ok=1 and utype=1 LIMIT 1")->num_rows();
	if($rownum<=0){return false;}else{return true;}
}



/**
 * 要请好友加入的练接
 * 活动期间使用--- (add:11-10-24)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_inviter_url($uid)
{
	if($uid==''||is_numeric($uid)==false){return 'null!';}
	$keys = activity_inviter_key($uid).'u0b8d'.$uid;
	//siteurl() from val_helper.php
	return siteurl().site_url('ver/inviter/'.$keys);
}



/**
 * 要请好友加入的练接键值加密，防止乱操作
 * 活动期间使用--- (add:11-10-24)
 * @access: public
 * @author: mk.zgc
 * @param: string,$uid 用户id
 * @return: bool 
 */
function activity_inviter_key($uid)
{
	$key = md5("tg.".$uid.".inviter.2011.10");
	$key = substr($key,8,16);
	return $key;
}



/**
 * 根据Url参数解析并并返回uid
 * 活动期间使用--- (add:11-10-24)
 * @access: public
 * @author: mk.zgc
 * @param: string,$keys url参数
 * @return: bool 
 */
function activity_inviter_url_resolve($keys)
{
	if(!empty($keys)&&$keys!=''){
		$keysarr = preg_split('/u0b8d/',$keys);
		if(!empty($keysarr)&&count($keysarr)==2){
			$key = $keysarr[0];
			$uid = $keysarr[1];
			$ukey= activity_inviter_key($uid);
			if(!empty($uid)&&is_numeric($uid)&&$ukey==$key){ return $uid; }
		}
	}
	return false;
}




/**
 * 根据用户信息判断是否显示登录任务向导
 * 活动期间使用--- (add:11-11-21)
 * @access: public
 * @author: mk.zgc
 * @param: string,$keys url参数
 * @return: bool 
 */
function activity_login_task()
{
	$CI = &get_instance();
	$logid = $CI->session->userdata('logid');
	if(is_num($logid))
	{
		$task_nav = $CI->session->userdata('tasknav');
		if($task_nav==0)
		{
			$CI->session->set_userdata('tasknav',1);
			$oknum = $CI->db->query("select id from user_gift_ok where uid=".$logid." LIMIT 1")->num_rows();
			if($oknum<=0){
				echo "<script> $(function(){ tb_show('温馨提示：','".site_url('task/login_task')."?height=140&width=340',false); }); </script>";
			}
		}
	}
}
?>