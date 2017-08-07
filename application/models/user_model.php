<?php
#单用户信息

class User_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
    /*普通用户登录*/
    function user_login($username,$password)
    {
		$password = pass_user($password); //加密处理
	    $this->db->select('id,mobile,email,password,classid,uid,name,c_id,a_id');
    	$this->db->from('user');
    	$this->db->where_in('classid',array(0,1));
    	$this->db->where('password',$password);
    	$this->db->where('mobile',$username);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	/*判断是否是企业用户*/
    function is_company_user($uid)
    {
    	$this->db->from('user');
    	$this->db->where('id',$uid);
    	$this->db->where('uid',1);
    	if($this->db->count_all_results()>0)
		{
			return true;
		}
		return false;
    }
	
	/*企业用户登录*/
    function user_company_login($username,$password)
    {
		$password = pass_company($password); //加密处理
	    $this->db->select('id,mobile,email,password,classid,uid,name,c_id,a_id');
    	$this->db->from('user');
    	$this->db->where('classid',2);
    	$this->db->where('uid',1);
    	$this->db->where('password',$password);
    	$this->db->where('mobile',$username);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*获取用户信息*/
    function info($uid=0)
    {
	    $this->db->select('user.*,place_province.p_name,place_city.c_name,place_area.a_name');
    	$this->db->from('user');
	    $this->db->join('place_province','user.p_id = place_province.p_id','left');
    	$this->db->join('place_city','user.c_id = place_city.c_id','left');
    	$this->db->join('place_area','user.a_id = place_area.a_id','left');
    	$this->db->where('user.id',$uid);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*获取用户信息(单项信息)*/
	function one_info($uid,$key='id',$back=false)
	{
		$this->db->select($key);
		$this->db->from('user');
		$this->db->where('id',$uid);
		$this->db->limit(1);
		$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			return $rs->$key;
		}
		else
		{
			return $back;
		}
	}
	
	/*累积访问次数*/
    function visite($uid=0)
    {
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $uid);
    	$this->db->update('user',array());
    }
	
	/*更新用户数据*/
    function user_update($uid=0,$data=NULL)
    {
    	$this->db->where('id', $uid);
    	return $this->db->update('user',$data);
    }
	
    /*判断用户帐号密码是否存在*/
    function user_is_ok($uid=0,$password='')
    {
    	$password = pass_user($password);
		$this->db->from('user');
		$this->db->where('id',$uid);
		$this->db->where('password',$password);
		return $this->db->count_all_results();
    }
	
    /*判断用户手机是否存在*/
    function is_reg_mobile($mobile=0)
    {
		$this->db->from('user');
		$this->db->where('mobile',$mobile);
		return $this->db->count_all_results();
    }

	
	/*获取用户链接*/
	function links($uid=0)
	{
		$this->db->select('name,photoID');
		$this->db->from('user');
		$this->db->where('id',$uid);
		$this->db->limit(1);
		$rs = $this->db->get()->row();
	    if(!empty($rs))
	    {
			$back = '<a href="'.site_url("user/".$uid).'" title="点击查看主页" class="tip" cmd="null" target="_blank">';
			$back.= '<img src="'.$this->faceS($rs->photoID).'" height="20" width="20" align="absmiddle" />';
			$back.= '&nbsp;&nbsp;<span>'.cutstr($rs->name,8).'</span></a>';
			return $back;
	    }
	    else
	    {
			return '<img src="'.$this->config->item('img_url').'none.jpg" height="20" width="20" align="absmiddle" title="系统消息!" />&nbsp;系统消息'; 
	    }
	}
	
	/*返回ID，可判断用户是否存在*/
    function user_id($uid=0)
    {
		return $this->one_info($uid,'id');
    }
    
    /*名称*/
	function name($uid=0)
	{
		return $this->one_info($uid,'name');
	}
	
	/*头像ID*/
	function photoID($uid)
	{
		return $this->one_info($uid,'photoID');
	}
	
	/*手机号*/
    function mobile($uid=0)
    {
    	return $this->one_info($uid,'mobile');
    }
    
    /*邮箱*/
	function email($uid)
	{
		return $this->one_info($uid,'email');
	}
	
	/*类型的ID值*/
	function classid($uid)
	{
		return $this->one_info($uid,'classid');
	}
	
	/*所在省份id*/
	function p_id($uid)
	{
		return $this->one_info($uid,'p_id');
	}
	
	/*所在城市id*/
	function c_id($uid)
	{
		return $this->one_info($uid,'c_id');
	}
	
	/*所在地区id*/
	function a_id($uid)
	{
		return $this->one_info($uid,'a_id');
	}
	
	/*头像*/
	function face($photoID=0)
	{
		if($photoID==0||$photoID== '')
		{
			return $this->config->item("face_url")."noneB.jpg";
		}
		else
		{
			return $this->config->item("face_url")."origin/".$photoID.".jpg";
		}
	}
	
	/*用户大头像*/
	function faceB($photoID=0)
	{
		if($photoID==0||$photoID== '')
		{
			return $this->config->item("face_url")."noneB.jpg";
		}
		else
		{
			return $this->config->item("face_url")."big/".$photoID.".jpg";
		}
	}
	
	/*用户小头像*/
	function faceS($photoID=0)
	{
		if($photoID==0||$photoID== '')
		{
			return $this->config->item("face_url")."noneS.jpg";
		}
		else
		{
			return $this->config->item("face_url")."small/".$photoID.".jpg";
		}
	}
	
	/*用户类型(工人Or业主)*/
	function user_types()
	{
		$this->db->select('id,title2');
		$this->db->from('user_type');
		$this->db->where('id <',2);
		$this->db->order_by('id','asc');
		return $this->db->get()->result();
	}

	/*工人类型(个人Or团队)*/
	function worker_types()
	{
		$this->db->select('id,title');
		$this->db->from('user_type');
		$this->db->where('type_id',0);
		$this->db->where('id <',3);
		$this->db->order_by('id','asc');
		return $this->db->get()->result();
	}

	/*搜索用到的类型*/
	function search_worker_types()
	{
		$this->db->select('id,title');
		$this->db->from('user_type');
		$this->db->where('type_id',0);
		$this->db->order_by('id','asc');
		return $this->db->get()->result();
	}
	
	/*工作年限类型*/
	function age_class()
	{
		$this->db->select('*');
		$this->db->from('age_class');
		$this->db->order_by('id','asc');
		return $this->db->get()->result();
	}
	
	/*返回团队/个人/全部*/
    function g_team_men($id=0)
	{
		$this->db->select('title');
		$this->db->from('user_type');
		$this->db->where('id',$id);
		$this->db->where('type_id !=',1);
		$this->db->limit(1);
		$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			echo $rs->title;
		}
		else
		{
			echo '全部';
		}
    }
    
    /*根据用户id返回团队id*/	
	function one2team_id($uid=0)
	{
		if(is_num($uid))
		{
		   	$this->db->select('id');
			$this->db->from('user');
			$this->db->where('uid',$uid);
			$this->db->where('classid',2);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				return $rs->id;
			}
		}
		return 0;
	}
	
	/*根据团队id返回创建者id*/	
	function team2one_id($tid=0)
	{
		if(is_num($tid))
		{
			$this->db->select('id');
			$this->db->from('user');
			$this->db->where('uid',$tid);
			$this->db->where('classid',2);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				return $rs->id;
			}
		}
		return 0;
	}
	
	/*通过用户ID获取用户创建的团队信息*/
    function team_info($uid=0)
    {
    	$this->db->select('user.id,user.name,user.photoID,user.note,user.addtime,user.p_id,user.c_id,user.a_id,user.address,user.uid,user.team_ckbj,user.team_fwxm,user.team_fwdq,place_province.p_name,place_city.c_name,place_area.a_name');
    	$this->db->from('user');
    	$this->db->join('place_province','user.p_id = place_province.p_id','left');
    	$this->db->join('place_city','user.c_id = place_city.c_id','left');
    	$this->db->join('place_area','user.a_id = place_area.a_id','left');
    	$this->db->where('user.uid',$uid);
    	$this->db->where('user.classid',2);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*根据团队ID获取团队成员数*/
    function team_num($tid=0)
    {
		$this->db->select('id');
		$this->db->from('team_user');
		$this->db->where('tid',$tid);
		return $this->db->count_all_results();
	}
	
	/*判断用户是否已经加入指定团队*/
    function is_team_user($tid,$uid)
    {
		$this->db->select('id');
		$this->db->from('team_user');
		$this->db->where('uid',$uid);
		$this->db->where('tid',$tid);
		if($this->db->count_all_results()>0)
		{
			return true;
		}
		return false;
	}

	/*判断是否已经实名认证*/
    function yz_sm($uid)
    {
		$this->db->select('*');
		$this->db->from('yz_sm');
		$this->db->where('uid',$uid);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
	
	/*显示用户身份的ID(个人/团队) 用于投标页面切换用户身份
	 * 
	 * $_SESSION["usertype"]=0 则返回团队身份id
	 * $_SESSION["usertype"]=1 则返回个人身份id
	 */
	function get_user_id($uid,$type=0)
	{
		if($type==0)
		{
		   #返回个人id
		   return $uid;
		}
		else
		{
		   #返回团队id
		   return $this->team2one_id($uid);
		}
	}
	

	/*从业时间*/
	function entry($id)
	{
		$id = get_num($id);
		if($id)
		{
			$this->db->select('title');
			$this->db->from('age_class');
			$this->db->where('id',$id);
			$this->db->limit(1);
			$entryRS = $this->db->get()->row();
			if(!empty($entryRS))
			{
				return $entryRS->title;
			}
		}
		return "未填写"; 
	}

	/*返回用户认证信息*/
	function approve($uid=0)
	{
		$this->db->select('approve_sj,approve_yx,approve_mm,approve_sm');
		$this->db->from('user');
		$this->db->where('id',$uid);
		return $this->db->get()->row();
	}

    /*返回用户认证信息*/
	function approves($uid=0,$html='<a class="yz_{tip}" title="{title}">&nbsp;</a>')
	{
		if(is_num($uid))
		{
			$this->db->select('id,approve_sj,approve_yx,approve_yhk,approve_sm');
			$this->db->from('user');
			$this->db->where('id',$uid);
			$this->db->limit(1);
			$approveRS = $this->db->get()->row();
			if(!empty($approveRS))
			{
				$html = '<a class="yz_{tip}" title="{title}">&nbsp;</a>';
				return $this->approve_helper($approveRS->id , $approveRS->approve_sj , $approveRS->approve_yx , $approveRS->approve_sm , $html);  
			}
		}
	}
    /*处理用户认证信息*/
	function approve_helper($uid='',$sj=0,$yx=0,$sm=0,$html='<a class="yz_{tip}" title="{title}">&nbsp;</a>')
	{
		//mobile
		if($sj==1){$sj = '';} else {$sj = '_no';}
		$html_1 = str_replace("{id}",$uid,$html); 
		$html_1 = str_replace("{title}","手机验证",$html_1);
		$html_1 = str_replace("{tip}","mobile".$sj,$html_1);
		$back = $html_1;
		//email
		if($yx==1){$yx = '';} else {$yx = '_no';}
		$html_2 = str_replace("{id}",$uid,$html); 
		$html_2 = str_replace("{title}","邮箱验证",$html_2);
		$html_2 = str_replace("{tip}","email".$yx,$html_2);
		$back.= $html_2;
		//identity
		if($sm==1){$sm = '';} else {$sm = '_no';}
		$html_3 = str_replace("{id}",$uid,$html); 
		$html_3 = str_replace("{title}","实名认证",$html_3);
		$html_3 = str_replace("{tip}","identity".$sm,$html_3);
		$back.= $html_3;
		return $back;
	}
	
	
	/*热门公司*/
	function hot_company()
	{
		$this->db->select('id,name,photoID');
		$this->db->from('user');
		$this->db->where('uid',1);
		$this->db->where('classid',2);
		$this->db->order_by('id','desc');
		$this->db->order_by('visited','desc');
		$this->db->limit(12);
		return $this->db->get()->result();
	}

	/*热门团队*/
	function hot_team()
	{
		$this->db->select('title,ad,tid');
		$this->db->from('team_ad');
		$this->db->order_by('s_date','desc');
		$this->db->order_by('id','desc');
		$this->db->limit(9);
		return $this->db->get()->result();
	}
	
	/*热门设计师*/
	function hot_design()
	{
		$this->db->select('user.id,user.name,user.photoID');
		$this->db->from('user');
		$this->db->join('skills','user.id=skills.workerid','left');
		$this->db->where('skills.industrys',612);
		$this->db->where('user.classid',0);
		$this->db->where('user.visited >',10);
		$this->db->group_by('user.id');
		$this->db->order_by('user.visited','desc');
		$this->db->order_by('user.id','desc');
		$this->db->limit(12);
		return $this->db->get()->result();
	}

	/*热门工人*/
	function hot_workers()
	{
		$this->db->select('id,name,photoID');
		$this->db->from('user');
		$this->db->where('visited >',200);
		$this->db->where('classid',0);
		$this->db->order_by('visited','desc');
		$this->db->order_by('id','desc');
		$this->db->limit(12);
		return $this->db->get()->result();
	}

	/*财富榜*/
	function user_cfb($classid=0)
    {
		$this->db->select('user.id,user.name');
		$this->db->select_sum('records.cost');
		$this->db->from('user');
		$this->db->join('records','records.uid=user.id','left');
		$this->db->where('user.classid',$classid);
		$this->db->group_by('user.id'); 
		$this->db->order_by('cost','desc');
		$this->db->limit(8);
		return $this->db->get()->result();
	}

	/*英雄榜*/
	function user_yxb($classid=0)
    {
		$this->db->cache_on();
    	$this->db->select('user.id,user.name,user.photoID,user.entry_age');
    	$this->db->select_sum('order_door.cost','counts');
    	$this->db->from('user');
    	$this->db->join('order_door','user.id=order_door.uid_2','left');
		//更正确的方式(但是现在的订单量过少)
    	//$this->db->select_sum('order_door.cost','counts');
    	//$this->db->from('order_door');
    	//$this->db->join('user','user.id=order_door.uid_2','left');
		//$this->db->group_by('order_door.id'); 
    	$this->db->where('user.classid',$classid);
    	$this->db->where('user.photoID !=',0);
		$this->db->where('user.id !=', 7070);
		$this->db->where('user.id !=', 7061);
		$this->db->where('user.id !=', 6405);
    	$this->db->group_by('user.id'); 
    	$this->db->order_by('counts','desc');
    	$this->db->order_by('user.id','desc');
    	$this->db->limit(5);
    	return $this->db->get()->result();
    }
	
    /*人气榜*/
    function user_rqb($classid=0)
    {
		$this->db->select('id,name,visited');
		$this->db->from('user');
		$this->db->where('classid',$classid);
		$this->db->order_by('visited','desc');
		$this->db->order_by('id','desc');
		$this->db->limit(8);
		return $this->db->get()->result();
    }	

}
?>