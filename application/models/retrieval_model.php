<?php
#投标信息

class Retrieval_Model extends CI_Model {
	
	public $g24time;
	
    function __construct()
    {
        parent::__construct();
		
		$this->g24time = dateDay24();
    }
    
    
    /*返回最新的N条记录*/
    function get_list($num=10)
    {
 	    $this->db->select('retrieval.id,retrieval.title,retrieval.c_id,place_city.c_name');
    	$this->db->from('retrieval');
    	$this->db->join('place_city','retrieval.c_id = place_city.c_id','left');
		$this->db->group_by('retrieval.id');
    	$this->db->order_by('retrieval.id','desc');
    	$this->db->limit($num);
    	return $this->db->get()->result();
    }
    
    /*累积访问次数*/
    function visite($id=0)
    {
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('retrieval',array());
    }
    
    /*判断用户是否已经加入某投标*/
    function R_election($uid=0,$rid=0)
    {
	    $this->db->select('uid,retrievalid,skills,note');
    	$this->db->from('retrieval_election');
    	$this->db->where('uid',$uid);
    	$this->db->where('retrievalid',$rid);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*最新招标的id*/
    function zb_new_id($uid)
    {
	    $this->db->select('id');
    	$this->db->from('retrieval');
    	$this->db->where('uid',$uid);
    	$this->db->order_by('id','desc');
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*最新招标*/
    function zb_new()
    {
 	    $this->db->select('retrieval.title,retrieval.id,retrieval_pic.pic');
    	$this->db->from('retrieval');
    	$this->db->join('retrieval_pic','retrieval_pic.rid = retrieval.rid','left');
    	$this->db->group_by('retrieval.id');
    	$this->db->order_by('retrieval.id','desc');
    	$this->db->limit(3,1);
    	return $this->db->get()->result();
    }
    
    /*最新招标*/
    function zb_ad()
    {
	    $this->db->select('id,title,cost');
    	$this->db->from('retrieval');
    	$this->db->where('UNIX_TIMESTAMP(endtime)>'.date(time()));
    	$this->db->where('isshow',0);
    	$this->db->order_by('id','desc');
    	$this->db->limit(10,1);
    	return $this->db->get()->result();
    }
    
    /*推荐招标*/
    function zb_tj()
    {
 	    $this->db->select('retrieval.title,retrieval.id,retrieval_pic.pic');
    	$this->db->from('retrieval');
    	$this->db->join('retrieval_pic','retrieval_pic.rid = retrieval.rid','left');
    	$this->db->group_by('retrieval.id');
    	$this->db->order_by('retrieval.id','desc');
    	$this->db->limit(1,0);
    	return $this->db->get()->result();
    }
    
    /*用户投标信息*/
    function election_sql($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval_election');
    	$this->db->where('retrievalid',$id);
		//返回SQL
		return $this->db->getSQL();
    }
    
    /*用于任务投标*/
    function retrieval_type($id=0)
    {
	    $this->db->select('team_or_men');
    	$this->db->from('retrieval');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	$rs = $this->db->get()->row();
    	if(!empty($rs))
    	{
    		$usertype = $rs->team_or_men;
    		if($usertype==0)
    		{
    			return 0;//个人任务
    		}
    		elseif($usertype==2)
    		{
    			return 2;//团队任务
    		}
    		else
    		{
    			return 1;//全部任务
    		}
    	}
    	return 0;//个人任务
    }

    /*任务详细信息*/
    function view($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('id',$id);
    	$this->db->where('isshow',0);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
	
    /*任务详细信息*/
    function get_view($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    /*任务进行中*/
    function view_ing($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('uid',$id);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)>='.$this->g24time);
    	$this->db->order_by('id','desc');
    	$this->db->limit(3);
    	return $this->db->get()->result();
    }  

    /*任务结束的*/
    function view_end($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('uid',$id);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)<'.$this->g24time);
    	$this->db->order_by('id','desc');
    	$this->db->limit(3);
    	return $this->db->get()->result();
    }
    
    /*任务最新的*/
    function view_new($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('uid',$id);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)>='.$this->g24time);
    	$this->db->order_by('id','desc');
    	$this->db->limit(8);
    	return $this->db->get()->result();
    } 
    
    /*任务高价的*/
    function view_max($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('uid',$id);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)>='.$this->g24time);
    	$this->db->order_by('cost','desc');
    	$this->db->limit(8);
    	return $this->db->get()->result();
    }
    
    /*附近的任务*/
    function view_near($c_id)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('c_id',$c_id);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)>='.$this->g24time);
    	$this->db->order_by('cost','desc');
    	$this->db->order_by('id','desc');
    	$this->db->limit(8);
    	return $this->db->get()->result();
    } 
    
    /*相似的任务*/
    function view_like($classid)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval');
    	$this->db->where('classid',$classid);
    	$this->db->where('isshow',0);
    	$this->db->where('UNIX_TIMESTAMP(endtime)>='.$this->g24time);
    	$this->db->order_by('cost','desc');
    	$this->db->order_by('id','desc');
    	$this->db->limit(8);
    	return $this->db->get()->result();
    }
    
    /*图片任务信息*/
    function view_img($id=0)
    {
 	    $this->db->select('retrieval.id,retrieval_pic.pic');
    	$this->db->from('retrieval');
    	$this->db->join('retrieval_pic','retrieval_pic.rid = retrieval.id','left');
    	$this->db->group_by('retrieval.id');
    	$this->db->order_by('retrieval.id','desc');
    	$this->db->limit(4);
    	return $this->db->get()->result();
    } 

    function pics($id=0)
    {
	    $this->db->select('*');
    	$this->db->from('retrieval_pic');
    	$this->db->where('rid',$id);
    	$this->db->order_by('id','desc');
    	$this->db->limit(15);
    	return $this->db->get()->result();
    } 

    function pic_num($id=0)
    {
    	$this->db->where('rid', $id);
    	$this->db->from('retrieval_pic');
    	return $this->db->count_all_results();
    } 
    
    /*返回任务状态及中标用户id*/
	function ok_uid($id=0)
	{
	    $this->db->select('uid');
    	$this->db->from('retrieval_election');
    	$this->db->where('retrievalid',$id);
    	$this->db->where('ok',1);
    	$this->db->limit(1);
    	$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			return $rs->uid;
		}
		return false;
	} 
	
	/*任务投标人数*/
	function election_num($id=0)
	{
    	$this->db->where('retrievalid', $id);
    	$this->db->from('retrieval_election');
    	return $this->db->count_all_results();
	}
	
	
	/*是否已发布投标，防止重复发布相同的*/
	function is_retrievaled($md5='')
	{
		$this->db->from('retrieval');
		$this->db->where('thisMD5',$md5);
		if( $this->db->count_all_results()>0 )
		{
			return true;
		}
		return false;
	}

	
	/*判断是否已经参加投标(工人或团队已参加投标则返回true)
	 * $uid=用户id , $tid=团队id ,$id=任务id*/
	function retrieval_uid($uid,$tid,$id)
	{
		#保证为数字
		if(is_num($uid)==false)
		{
			$uid = 0;
		}
		if(is_num($tid)==false)
		{
			$tid = 0;
		}
		if(is_num($id)==false)
		{
			$id = 0;
		}
		
	    $this->db->select('uid');
    	$this->db->from('retrieval_election');
    	$this->db->where('(uid='.$uid.' or uid='.$tid.')');
    	$this->db->where('retrievalid',$id);
    	$this->db->limit(1);
    	$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			return $rs->uid;  //已经参加了
		}
		else
		{
			return false;   //未参加
		}
	}
	
	/*返回类别名称*/
	function industry_class_title($id=0)
	{
		if(is_num($id))
		{
			$this->db->select('title');
			$this->db->from('industry_class');
			$this->db->where('id',$id);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				return $rs->title;
			}
		}
	}
	
	/*返回单个工种名称industry*/
	function industry_title($id=0)
	{
		if(is_num($id))
		{
			$this->db->select('title');
			$this->db->from('industry');
			$this->db->where('id',$id);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				return $rs->title;
			}
		}
		elseif(is_array($id))
		{
			$this->db->select('title');
			$this->db->from('industry');
			$this->db->where_in('id',$id);
			return $this->db->get()->result();
		}
	}
	
	/*返回返回返回工种industryid*/
	function show_industrys($ids)
	{
		$industrys = '';
		$industryid = split(",",$ids);
		if (is_array($industryid))
		{
			$i = 0;
			$industry = $this->industry_title($industryid);
			if(!empty($industry))
			{
				foreach($industry as $item)
				{
					$i++;
					if($i>1){ $industrys.= "、";}
					$industrys.= $item->title;
				}
			}
		}
		echo $industrys;
	}
	
	
	/*返回列表sql语句,用于分页*/
	function listsql($logid)
	{
        $this->db->select('retrieval.id,retrieval.title,retrieval.addtime,retrieval.endtime,retrieval.visited');
        $this->db->from('retrieval');
        $this->db->join('user','retrieval.uid = user.id','left');
        $this->db->where('retrieval.uid', $logid);
        $this->db->order_by('retrieval.id','desc');
		//返回SQL
		return $this->db->getSQL();
	}
	
	/*返回列表sql语句,用于用户页面*/
	function User_Retrieval($logid)
	{
        $this->db->select('retrieval.id,retrieval.title,retrieval.addtime');
        $this->db->from('retrieval');
        $this->db->join('retrieval_election','retrieval_election.retrievalid = retrieval.id','left');
        $this->db->where('retrieval_election.uid', $logid);
        $this->db->group_by('retrieval.id');
        $this->db->order_by('retrieval_election.id','desc');
        $this->db->limit(10);
        return $this->db->get()->result();
	}
	
	/*删除投标任务数据*/
	function del($id=0,$uid=0,$type=false)
	{
		//删除图片
		$this->del_pic($id,$uid,$type);
		
		//需要用户登录权限
		if($type==false)
		{
			$this->db->where('uid', $uid);
		}
		$this->db->where('id', $id);
		return $this->db->delete('retrieval');
	}
	
	/*删除投标任务图片数据*/
	function del_pic($id=0,$uid=0,$type=false)
	{
		//需要用户登录权限
		if($type==false)
		{
			$this->db->where('uid', $uid);
		}
		$this->db->where('rid', $id);
		return $this->db->delete('retrieval_pic');
	}
	
	/*添加投标任务图片数据*/
	function add_pic($data=NULL)
	{
		return $this->db->insert('retrieval_pic',$data);
	}
	
	
	/*取消参加投标任务*/
	function join_off($id=0,$uid=0)
	{
		$this->db->where('uid', $uid);
		$this->db->where('retrievalid', $id);
		return $this->db->delete('retrieval_election');
	}
	
	/*返回投标页面查询的sql*/
	function sql_retrieval()
	{
		//*****接收参数，并进行xss过滤*****
		
		//$c_id = $this->input->getnum("c_id");
		//$a_id = $this->input->getnum("a_id");
		$c_id = $this->Place_Model->c_id;
		$a_id = $this->Place_Model->a_id;
		
		$usertype = $this->input->getnum("usertype");
		$industry = $this->input->get("industry");
		$classid = $this->input->getnum("classid");
		$keyword = $this->input->gethtml("keyword");
		//排序参数
		$o_visited = $this->input->getnum("o_visited");
		$o_cost = $this->input->getnum("o_cost");
		$o_endtime = $this->input->getnum("o_endtime");
		
		//生成搜索条件
		$this->db->select('retrieval.id,retrieval.team_or_men,retrieval.title,retrieval.classid,retrieval.industryid,retrieval.uid,retrieval.cost');
		$this->db->from('retrieval');
		$this->db->where('isshow',0);
		//筛选任务城市
		if( is_numeric($c_id) ) { $this->db->where('retrieval.c_id',(int)$c_id); }
		//筛选任务区域
		if( is_numeric($a_id) ) { $this->db->where('retrieval.a_id',(int)$a_id); }
		//筛选任务类型
		if( is_numeric($usertype) ) { $this->db->where('retrieval.team_or_men',$usertype); }
		//筛选任务类别
		if( is_numeric($classid) ) { $this->db->where('retrieval.classid',$classid); }
		//筛选需求工种
		if($industry!='') {
			$industryArr = split('_',$industry);
			$this->db->where_in('retrieval.industryid',$industryArr);
		}
		//关键词模糊搜索
		if($keyword!='')
		{
			$like_on[] = array('retrieval.title'=>$keyword);
			$like_on[] = array('retrieval.note'=>$keyword);
			$this->db->like_on($like_on);
		}
		
		//点击次数排序
		$o_visited = order_type($o_visited);
		if( $o_visited != false )
		{
			$this->db->order_by('retrieval.visited',$o_visited);
		}
		//任务预费排序
		$o_cost = order_type($o_cost);
		if( $o_cost != false )
		{
			$this->db->order_by('retrieval.cost',$o_cost);
		}
		//结束时间排序
		$o_endtime = order_type($o_endtime);
		if( $o_endtime != false )
		{
			$this->db->order_by('retrieval.endtime',$o_endtime);
		}
		//基础排序
		$this->db->order_by('retrieval.id','desc');
		
		//返回SQL
		return $this->db->getSQL();
	 }


}
?>