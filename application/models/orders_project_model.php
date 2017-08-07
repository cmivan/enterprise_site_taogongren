<?php
#简化订单信息

class Orders_project_Model extends CI_Model {
	
	//初始化用户类型为工人
	public $user_type = 0;

    function __construct()
    {
        parent::__construct();
    }
	
/**
 * 用于区分不用的用户操作
 */
    function user_where($uid = 0)
	{
		if( $this->user_type == 0 )
		{
			$this->db->where('uid_2', $uid); //工人
		}
		else
		{
			$this->db->where('uid', $uid); //业主
		}
	}



/**
 * 返回用户的订单列表sql
 */
	function user_orders_sql($uid=0)
	{
		$this->user_where($uid);
		$this->db->from('order_project');
		$this->db->order_by('id', 'desc');
		//返回SQL
		return $this->db->getSQL();
	}
	
/**
 * 获取该订单的基本信息
 */	
	function user_orders_view($uid=0,$id=0)
	{
		$this->user_where($uid);
		$this->db->from('order_project');
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
/**
 * 获取该订单的合同信息
 */	
	function user_orders_deal($id=0)
	{
		$this->db->from('order_project_deal');
		$this->db->where('o_id', $id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
/**
 * 获取该订单的合同信息
 */	
	function user_orders_steps($id=0)
	{
		$this->db->from('order_project_step');
		$this->db->where('o_id', $id);
		$this->db->order_by('stepNO', 'asc');
		return $this->db->get()->result();
	}
	
	
}
?>