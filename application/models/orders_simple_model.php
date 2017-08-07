<?php
#简化订单信息

class Orders_simple_Model extends CI_Model {
	
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
		$this->db->from('order_simple');
		$this->db->where('o_id', 0);
		$this->db->order_by('id', 'desc');
		//返回SQL
		return $this->db->getSQL();
	}


/**
 * 获取该订单的基本信息.判断当前步骤是否已经打款
 */	
	function user_orders_info($uid=0,$id=0)
	{
		$this->user_where($uid);
		$this->db->from('order_simple');
		$this->db->where('id', $id);
		$this->db->where('ok', 2);
		$this->db->where('refund_ok', 1);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
/**
 * 获取用户指定订单详细信息
 */	
	function user_orders_view($uid=0,$id=0)
	{
		$this->user_where($uid);
		$this->db->from('order_simple');
		$this->db->where('id', $id);
		$this->db->where('o_id', 0);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
/**
 * 获取用户指定订单步骤详细信息
 */	
	function user_orders_view_step($uid=0,$id=0)
	{
		$this->user_where($uid);
		$this->db->from('order_simple');
		$this->db->where('o_id', $id);
		$this->db->order_by('id', 'desc');
		return $this->db->get()->result();
	}


/**
 * 判断该订单id是否存在，并该用户有操作权限
 */	
	function user_orders_patch_info($uid=0,$id=0)
	{
		$this->user_where($uid);
		$this->db->from('order_simple');
		$this->db->where('o_id', 0);
		$this->db->where('id', $id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}


/**
 * 查找是否已经存在该上门单
 */	
	function user_ordersmd5_view($uid=0,$orderMD5=0)
	{
		$this->user_where($uid);
		$this->db->select('addtime');
		$this->db->from('order_simple');
		$this->db->where('orderMD5', $orderMD5);
		$this->db->limit(1);
		return $this->db->get()->row();
	}


/**
 * 将用户的当前单设置为已成功支付的订单
 */	
	function user_orders_update($uid=0,$id=0)
	{
		$data = array(
               'refund_ok' => 2,
               'ok' => 1,
               'updatetime' => dateTime()
               );
		$this->db->where('uid_2', $uid);
		$this->db->where('id', $id);
		$this->db->where('ok', 2);
		return $this->db->update('order_simple',$data);
	}

/**
 * 订单回复及更改状态
 */	
	function user_orders_update_msg($uid=0,$id=0,$msg='')
	{
		$data = array(
               'refund_ok' => 0,
			   'msg' => $msg,
               'updatetime' => dateTime()
               );
		$this->db->where('uid_2', $uid);
		$this->db->where('id', $id);
		$this->db->where('ok', 2);
		$this->db->where('refund_ok', 1);
		return $this->db->update('order_simple',$data);
	}



/**
 * 获取简化单当前的状态(是否完成)
 */	
	function order_stat($id=0)
	{
		$id = get_num($id,'');
		
		$this->db->from('order_simple');
    	$this->db->where('(id='.$id.' or o_id='.$id.') and ok!=1');
    	$num = $this->db->count_all_results();
		if( is_num($num) && $num>0 )
		{
			return false;
		}
		return true;
	}

	
}
?>