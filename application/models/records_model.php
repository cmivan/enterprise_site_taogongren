<?php
#用户收入记录

class Records_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /*用户收入sql(用于页面列表处理)*/	
	function record_in($uid)
	{
	    $this->db->select('*');
    	$this->db->from('records');
    	$this->db->where('uid',$uid);
    	$this->db->where('cost >',0);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}

	/*用户消费sql(用于页面列表处理)*/	
	function record_out($uid)
	{
	    $this->db->select('*');
    	$this->db->from('records');
    	$this->db->where('uid',$uid);
    	$this->db->where('cost <',0);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}

	/*用户提现/转账sql(用于页面列表处理)*/	
	function record_transfer($uid)
	{
	    $this->db->select('*');
    	$this->db->from('records_transfer');
    	$this->db->where('uid',$uid);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}

	/*用户充值临时表*/	
	function record_temp_data($r3_Amt,$r4_Cur,$r6_Order)
	{
	    $this->db->select('id,p2_Order,p3_Amt,p4_Cur,cost_type,uid');
    	$this->db->from('rating_temp');
    	$this->db->where('p3_Amt',$r3_Amt);
		$this->db->where('r4_Cur',$r4_Cur);
		$this->db->where('r6_Order',$r6_Order);
		$this->db->where("(cost_type='T' or cost_type='S') and ok=0");
		$this->db->limit(1);
		return $this->db->row();
	}
	
	
	/*用户信用金*/	
	function credits($uid)
	{
	    $this->db->select_sum('cost');
    	$this->db->from('records');
    	$this->db->where('uid',$uid);
    	$this->db->where('costype','S_XY');
    	$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			return get_num($rs->cost,0);
		}
		return 0;
	}
	
	
	/*账户总记录*/	
	function balances($uid)
	{
		if(is_num($uid))
		{
			$this->db->select_sum('cost');
			$this->db->from('records');
			$this->db->where('uid',$uid);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				return get_num($rs->cost,0);
			}
		}
		return 0;
	}
	
	/**
	 * 返回用户账户余额
	 * 参数：$T="T" 淘工币 $T="S" 实币
	 */
	function balance_cost($uid,$T="T")
	{
		if($T=='T'||$T=='S'||$T=='S_XY'){
			if(is_num($uid))
			{
				$this->db->select_sum('cost');
				$this->db->from('records');
				$this->db->where('uid',$uid);
				$this->db->where('costype',$T);
				$rs = $this->db->get()->row();
				if(!empty($rs))
				{
					return get_num($rs->cost,0);
				}
			}
		}
		return 0; //返回剩余金额
	}
	
	/**
	 * 操作用户户账户余额
	 * $uid  被操作用户
	 * $cost 被操作金额, $cost>0则充值，$cost<0则扣除
	 * $tip  记录提示记录
	 * $T="T" 淘工币, $T="S"实币
	 */
	function balance_control($uid=0,$cost=0,$tip='',$T='')
	{
		//保证操作类型不超出操作范围
		if($T=="T"||$T=="S"||$T=="S_XY")
		{
			$ip = ip();
			$tip = str_replace("'","\"",$tip); //过滤字符
			$sysnum = time();
			if(is_num($uid)&&is_num($cost)&&$tip!='')
			{
				//获取总账户，金额
				$cost_count = $this->balance_cost($uid,$T);
				if(($cost_count + $cost)>=0)
				{
					//运行事务
					$this->db->trans_start();
					$data = array(
						  'uid' => $uid ,
						  'cost' => $cost ,
						  'note' => $tip ,
						  'ip' => $ip ,
						  'sysnum' => $sysnum ,
						  'costype' => $T
					);
					$this->db->insert('records', $data); 
					$this->db->trans_complete();
					return true;
				}
			}
		}
		return false;
	}


	
	
}
?>