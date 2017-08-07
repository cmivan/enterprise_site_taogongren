<?php
#用户收入记录

class Records_temp_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/*判断是否已经提交充值*/
	function is_recorded($uid=0,$orderid=0)
	{
		$this->db->from('rating_temp');
		$this->db->where('uid',$uid);
		$this->db->where('p2_Order',$orderid);
		if( $this->db->count_all_results()>0 )
		{
			return true;
		}
		return false;	
	}


	/*获取用户充值临时表*/	
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
	
	/*充值到用户充值临时表*/	
	function record_temp_add($data=NULL)
	{
		return $this->db->insert('rating_temp',$data);
	}
	
	/*充值到用户充值表*/	
	function record_charge_add($data=NULL)
	{
		return $this->db->insert('records_charge',$data);
	}
	
	/*删除用户充值临时表*/	
	function record_temp_del($pid=0)
	{
		$this->db->set('ok',1);
		$this->db->where('id',$pid);
		$this->db->limit(1);
		return $this->db->update('rating_temp');
	}


	
	
}
?>