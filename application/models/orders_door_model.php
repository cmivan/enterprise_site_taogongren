<?php
#简化订单信息

class Orders_door_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/**
 * 返回用户的订单列表sql
 */	
	function user_orders_sql($uid=0,$type=0)
	{
		if($type==0)
		{
			$this->db->where('uid_2', $uid);//工人
		}
		else
		{
			$this->db->where('uid', $uid);//业主
		}
		$this->db->from('order_door');
		$this->db->order_by('id', 'desc');
		//返回SQL
		return $this->db->getSQL();
	}

	
/**
 * 获取用户指定订单详细信息
 */	
	function user_orders_view($uid=0,$id=0)
	{
		$this->db->from('order_door');
    	$this->db->where('(uid = ' . $uid . ' or uid_2 = ' . $uid . ')');
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	
/**
 * 查找是否存在相同的该上门单
 */	
	function user_orders_md5_view($uid=0,$md5=0)
	{
		$this->db->select('addtime');
		$this->db->from('order_door');
    	$this->db->where('orderMD5', $md5);
		$this->db->where('uid', $uid);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
/**
 * 获取用户指定订单步骤详细信息
 */	
	function user_orders_view_step($id=0)
	{
		$this->db->from('order_door_step');
    	$this->db->where('stepid', $id);
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result();
	}
	
/**
 * 获取用户指定订单步骤详细信息
 */	
	function user_orders_step_add($data=0)
	{
		return $this->db->insert('order_door_step',$data);
	}


	
}
?>