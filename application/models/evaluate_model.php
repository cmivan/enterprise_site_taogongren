<?php
#单用户信息

class Evaluate_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回10条用户评价(包含返回用户信息)
 */
	function User_Evaluate($uid)
	{
		$this->db->select('evaluate.uid,evaluate.note,evaluate.addtime,user.name');
		$this->db->from('evaluate');
		$this->db->join('user','evaluate.uid=user.id','left');
		$this->db->where('evaluate.uid_2',$uid);
		$this->db->order_by('evaluate.id','desc');
		$this->db->limit(10);
		return $this->db->get()->result();
	}
  
	
/**
 * 返回某用户某类型下 所有被评论的内容
 */
	function User_Evaluated_all($uid=0,$classid=0)
	{
		$this->db->select('scorarr');
		$this->db->from('evaluate');
		$this->db->where('uid_2',$uid);
		$this->db->like('scorarr',$classid);
		return $this->db->get();
	}
	
	
	
    
    /*指定用户总被评数*/
    function all_rating_num($uid=0)
    {
    	$this->db->where('uid_2', $uid);
    	$this->db->from('evaluate');
    	return $this->db->count_all_results();
    }
    
    /*指定用户好评数*/
    function good_rating_num($uid=0)
    {
    	$this->db->where('uid_2', $uid);
    	$this->db->where('haoping', 1);
    	$this->db->from('evaluate');
    	return $this->db->count_all_results();
    }
	
    
    /*返回好评分类*/	
	function rating_class($classid=0)
	{
	    $this->db->select('id,title');
    	$this->db->from('rating_class');
    	$this->db->where('classid',$classid);
    	$this->db->order_by('id','asc');
    	return $this->db->get()->result();
	}
	
	/*返回用户的好评率*/
	function haoping_sroc($uid)
	{
		$rownum = $this->all_rating_num($uid);  //总评论数
		$haonum = $this->good_rating_num($uid); //好评数
		if(is_num($haonum)&&is_num($rownum)&&$haonum!=0)
		{
			$backScor = ($haonum/$rownum)*100;
			$backScor = round($backScor,2);
			return "<span>".$backScor."</span> %";
		}
		return '<span>0</span> %';
	}


    /*某用户被打分评分*/	
	function evaluate_scor($uid_2=0)
	{
	    $this->db->select_sum('haoping');
    	$this->db->from('evaluate');
    	$this->db->where('uid_2',$uid_2);
    	return $this->db->get()->row()->haoping;
	}
	
    
    /*某用户被好中差评分*/	
	function rating_scor($uid_2=0)
	{
	    $this->db->select_sum('scor_total');
    	$this->db->from('evaluate');
    	$this->db->where('uid_2',$uid_2);
    	return $this->db->get()->row()->scor_total;
	}
	
	
	/*返回用等级的*/
	function level_sroc($uid=0)
	{
		$Scor = 0; //初始化
		$rscor = 0;
		$ascor = 0;
		if( is_num($uid) )
		{
			//好中差评分
			$ascor = $this->evaluate_scor($uid);
			//打分评分
			$rscor = $this->rating_scor($uid);
			//计算总值
			if( is_numeric($ascor) && is_numeric($rscor) )
			{
				//公式：中差评分总分数*100+星级评分*5
				$Scor = $ascor*100 + $rscor*5;  //计算分值
			}
			if($Scor<=999 && $Scor>=0){
				//普通级-1 (0~999)  大概6次评价
				$Scor = 1;
			}elseif($Scor<=2799 && $Scor>=1000){
				//普通级-2 (1000~2799)
				$Scor = 2; 
			}elseif($Scor<=4799 && $Scor>=2800){
				//普通级-3 (2800~4799)
				$Scor = 3;
			}elseif($Scor<=7799 && $Scor>=4800){
				//普通级-4 (4800~7799)
				$Scor = 4;
			}elseif($Scor<=10000 && $Scor>=7800){
				//普通级-5 (7800~10000)
				$Scor = 5;
			}else{
				$Scor = 6;
			}
		} 
		return $Scor;
	}

}
?>