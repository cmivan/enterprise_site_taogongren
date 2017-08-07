<?php
#单用户信息

class User_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

/**
 * 判断用户是否存在
 */
    function user_id($uid=0)
    {
    	$u = $this->db->query("select id from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($u)){
			return $u->id;
		}else{
			return false;
		}
    } 

	
/**
 * 用户登录
 */
    function user_login($username,$password)
    {
		$password = pass_user($password); //加密处理
		return $this->db->query("select id,mobile,email,password,classid,uid,name,c_id,a_id from
		   `user` where (classid=0 or classid=1) and password='".$password."' and mobile='".$username."'")->row();
    }
	
    function user_company_login($username,$password)
    {
		$password = pass_company($password); //加密处理
		return $this->db->query("select id,mobile,email,password,classid,uid,name,c_id,a_id from
		   `user` where classid=2 and uid=1 and password='".$password."' and (mobile='".$username."' or email='".$username."')")->row();
    }	

/**
 * 获取用户信息
 */
    function info($uid=0)
    {
	    //return $this->db->query("select W.id,W.name,W.classid,W.sex,W.photoID,W.qq,W.email,W.addr_adv,W.address,W.note,W.visited,W.entry_age,P.p_name,C.c_name,A.a_name from `user` W left join place_province P on W.p_id=P.p_id left join place_city C on W.c_id=C.c_id left join place_area A on W.a_id=A.a_id where W.id=$uid LIMIT 1")->row();
		return $this->db->query("select W.*,P.p_name,C.c_name,A.a_name from `user` W left join place_province P on W.p_id=P.p_id left join place_city C on W.c_id=C.c_id left join place_area A on W.a_id=A.a_id where W.id=$uid LIMIT 1")->row();
    }	
    
    
/**
 * 累积访问次数
 */
    function visite($uid=0)
    {
    	$this->db->query("update `user` set visited=visited+1 where id=$uid LIMIT 1");
    }
	
	
/**
 * 删除用户
 */
    function del($uid=0)
    {
		return $this->db->query("delete from user where id=".$uid);
    }
	
	
/**
 * 判断用户帐号密码是否存在
 */
    function user_is_ok($uid=0,$password='')
    {
    	return $this->db->query("select id from `user` where (id=".$uid." and password = '".pass_user($password)."')")->num_rows();
    } 
	
	
	
/**
 * 站内最新短消息数目
 */
    function new_msg_num($uid=0)
    {
    	return $this->db->query("select id from sendmsg where suid=$uid and checked=0 and su_del=0")->num_rows();
    }
	
/**
 * 返回用户手机号
 */
    function mobile($uid=0)
    {
		$grs=$this->db->query("select mobile from `user` where id=".$uid." LIMIT 1")->row();
	    if(!empty($grs)){ return $grs->mobile; }else{ return ''; }
    }

/**
 * 获取用户链接
 */
	function links($uid=0)
	{
	    $user = $this->db->query("select name,photoID from `user` where id=".$uid." LIMIT 1")->row();
	    if(!empty($user)){
			$back = '<a href="'.site_url("user/".$uid).'" title="点击查看主页" class="tip" target="_blank">';
			$back.= '<img src="'.$this->faceS($user->photoID).'" height="20" width="20" align="absmiddle" />';
			$back.= '&nbsp;&nbsp;<span>'.cutstr($user->name,8).'</span></a>';
			return $back;
	    }else{
			return '<img src="/public/images/none.jpg" height="20" width="20" align="absmiddle" title="系统消息!" />&nbsp;系统消息'; 
	    }
	}	
	
/**
 * 获取用户名称
 */
	function name($uid=0)
	{
	    $grs=$this->db->query("select name from `user` where id=".$uid." LIMIT 1")->row();
	    if(!empty($grs)){ return $grs->name; }else{ return ''; }
	}
	
/**
 * 用户头像ID
 */
	function photoID($uid)
	{
		$grs = $this->db->query("select photoID from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->photoID; }else{ return ''; }
	}
	
/**
 * 用户头像
 */
	function face($photoID=0)
	{
		if($photoID==0||$photoID=="")
		{
			return $this->config->item("face_url")."noneB.jpg";
		}else{
			return $this->config->item("face_url")."origin/".$photoID.".jpg";
		}
	}
/**
 * 用户大头像
 */
	function faceB($photoID=0)
	{
		if($photoID==0||$photoID=="")
		{
			return $this->config->item("face_url")."noneB.jpg";
		}else{
			return $this->config->item("face_url")."big/".$photoID.".jpg";
		}
	}
/**
 * 用户小头像
 */
	function faceS($photoID=0)
	{
		if($photoID==0||$photoID=="")
		{
			return $this->config->item("face_url")."noneS.jpg";
		}else{
			return $this->config->item("face_url")."small/".$photoID.".jpg";
		}
	}
	
/**
 * 用户邮箱
 */
	function email($uid)
	{
		$grs = $this->db->query("select email from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->email; }else{ return ''; }
	}
	
	
/**
 * 用户类型的ID值
 */
	function classid($uid)
	{
		$grs = $this->db->query("select classid from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->classid; }else{ return ''; }
	}
	
	
/**
 * 用户类型(工人Or业主)
 */
	function user_types()
	{
		return $this->db->query("select id,title2 from `user_type` where id<2 order by id asc")->result();
	}
	
/**
 * 工人类型(个人Or团队)
 */
	function worker_types()
	{
		return $this->db->query("select id,title from `user_type` where type_id=0 order by id asc")->result();
	}
	
/**
 * 工作年限类型
 */
	function age_class()
	{
		return $this->db->query("select * from age_class order by id asc")->result();
	}


/**
 * 用户所在省份id
 */
	function p_id($uid)
	{
		$grs = $this->db->query("select p_id from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->p_id; }else{ return ''; }
	}
	
/**
 * 用户所在城市id
 */
	function c_id($uid)
	{
		$grs = $this->db->query("select c_id from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->c_id; }else{ return ''; }
	}
	
	
/**
 * 用户所在地区id
 */
	function a_id($uid)
	{
		$grs = $this->db->query("select a_id from `user` where id=".$uid." LIMIT 1")->row();
		if(!empty($grs)){ return $grs->a_id; }else{ return ''; }
	}


/**
 * 返回团队/个人/全部
 */
    function g_team_men($id=0)
	{
		$rs=$this->db->query("select title from user_type where id=$id and type_id<>1 LIMIT 1")->row();
		if(!empty($rs)){ echo $rs->title; }else{ echo "全部"; }
    }


/**
 * 根据用户id返回团队id
 */	
function one2team_id($uid=0)
{
	$Tid=0;
	if(is_numeric($uid)){
	   $rs = $this->db->query("select id from `user` where uid=".$uid." and classid=2 LIMIT 1")->row();
	   if(!empty($rs)){$Tid = $rs->id;}
	   }
	return $Tid;
}

/**
 * 根据团队id返回创建者id
 */	
function team2one_id($tid=0)
{
	$uid=0;
	if(is_num($tid)){
	   $rs = $this->db->query("select id from `user` where uid=".$tid." and classid=2 LIMIT 1")->row();
	   if(!empty($rs)){$uid = $rs->id;}
	}
	return $uid;
}

/**
 * 通过用户ID获取用户创建的团队信息
 */
    function team_info($uid=0)
    {
		return $this->db->query("select W.id,W.name,W.photoID,W.note,W.addtime,W.p_id,W.c_id,W.a_id,W.address,W.uid,W.team_ckbj,W.team_fwxm,W.team_fwdq,P.p_name,C.c_name,A.a_name from `user` W left join place_province P on W.p_id=P.p_id left join place_city C on W.c_id=C.c_id left join place_area A on W.a_id=A.a_id where W.uid=".$uid." and W.classid=2 LIMIT 1")->row();
    }
	

/**
 * 根据团队ID获取团队成员数
 */
    function team_num($Tid=0)
    {
		return $this->db->query("select id from `team_user` where tid=".$Tid)->num_rows();
    }
	

/**
 * 判断用户是否已经加入指定团队
 */
    function is_team_user($Tid,$uid)
    {
		return $this->db->query('select id from `team_user` where uid='.$uid.' and tid='.$Tid)->num_rows();
    }
	

/**
 * 判断是否已经实名认证
 */
    function yz_sm($uid)
    {
		return $this->db->query('select * from `yz_sm` where uid='.$uid.' LIMIT 1')->row();
    }
	
	
/******显示用户身份的ID(个人/团队) 用于投标页面切换用户身份
$_SESSION["usertype"]=0 则返回团队身份id
$_SESSION["usertype"]=1 则返回个人身份id*/
function get_user_id($uid,$type=0)
{
	if($type==0){
	   #返回个人id
	   return $uid;
	}else{
	   #返回团队id
	   return $this->team2one_id($uid);
	}
}
	
	
	

	
	
	
/**
 * 从业时间
 */
	function entry($id)
	{
		$id = is_num($id);
		if($id){
			$e=$this->db->query("select title from age_class where id=$id LIMIT 1")->row();
			if(!empty($e)){ return $e->title;}
		}
		return "未填写"; 
	}


  function approve($uid=0)
  {
	  return $this->db->query("select approve_sj,approve_yx,approve_mm,approve_sm from `user` where id=".$uid." LIMIT 1")->row();
  }
	

/**
 * 返回用户认证信息
 */
  function approves($uid=0,$html='<a class="yz_{tip}" title="{title}">&nbsp;</a>')
  {
    if(is_num($uid)){
		$a_row = $this->db->query("select `id`,`approve_sj`,`approve_yx`,`approve_yhk`,`approve_sm` from `user` where id=".$uid)->row();
		if(!empty($a_row)){
			//手机
			if($a_row->approve_sj==1){$m_ok="";}else{$m_ok="_no";}
               $html_1 = str_replace("{id}",$a_row->id,$html); 
               $html_1 = str_replace("{title}","手机验证",$html_1);
               $html_1 = str_replace("{tip}","mobile".$m_ok,$html_1);
			   $back = $html_1;
			 //邮箱
			if($a_row->approve_yx==1){$y_ok="";}else{$y_ok="_no";}
               $html_2 = str_replace("{id}",$a_row->id,$html); 
               $html_2 = str_replace("{title}","邮箱验证",$html_2);
               $html_2 = str_replace("{tip}","email".$y_ok,$html_2);
			   $back.= $html_2;
			 //实名
			if($a_row->approve_sm==1){$s_ok="";}else{$s_ok="_no";}
               $html_3 = str_replace("{id}",$a_row->id,$html); 
               $html_3 = str_replace("{title}","实名认证",$html_3);
               $html_3 = str_replace("{tip}","identity".$s_ok,$html_3);
			   $back.= $html_3;
			return $back;  
		}
     }
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
	
	
/**
 * 热门团队
 */
    function hot_team()
    {
        return $this->db->query("select title,ad,tid from team_ad order by s_date desc,id desc limit 9")->result();
    }
	
/**
 * 热门设计师
 */
    function hot_design()
    {
        return $this->db->query("select W.id,W.name,W.photoID from `user` W left join skills S on W.id=S.workerid left join industry I on I.id=S.industryid where W.classid=0 and I.industryid=612 group by W.id order by visited desc,W.id desc limit 12")->result();
    }

/**
 * 热门工人
 */
    function hot_workers()
    {
        return $this->db->query("select id,name,photoID,visited from `user` where classid=0 order by visited desc,id desc limit 12")->result();
    }

/**
 * 财富榜
 */
    function user_cfb($t=0)
    {
		return $this->db->query("select W.id,W.name,sum(R.cost) as cost from `user` W left join records R on R.uid=W.id where W.classid=".$t." group by W.id order by cost desc limit 8")->result();
    }

/**
 * 英雄榜
 */
    function user_yxb($t=0)
    {
		//return $this->db->query("select W.id,W.name,count(O.id) as counts from `user` W left join order_door O on W.id=O.uid_2 where W.classid=".$t." group by W.id order by counts desc,W.id desc limit 8")->result();
		//return $this->db->query("select W.id,W.name,W.photoID,W.entry_age,count(O.id) as counts from `user` W left join order_door O on W.id=O.uid_2 where (W.classid=".$t." and W.photoID<>0) group by W.id order by counts desc,W.id desc limit 5")->result();
		
		//2012.2.14临时限制 
		return $this->db->query("select W.id,W.name,W.photoID,W.entry_age,count(O.id) as counts from `user` W left join order_door O on W.id=O.uid_2 where (W.classid=".$t." and W.photoID<>0 and W.id<>7070 and W.id<>7061 and W.id<>6405) group by W.id order by counts desc,W.id desc limit 5")->result();
    }
	
/**
 * 人气榜
 */
    function user_rqb($t=0)
    {
		return $this->db->query("select id,name,visited from `user` where classid=".$t." order by visited desc,id desc limit 8")->result();
    }	

}
?>