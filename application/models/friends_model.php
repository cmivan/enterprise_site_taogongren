<?php
#单用户信息

class Friends_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回好友列表Sql
 */
  function listsql_friends($uid)
  {
		$this->db->select('*');
		$this->db->from('friends');
		$this->db->where('uid',$uid);
		$this->db->where('isok',1);
		$this->db->where('isblack',0);
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
  }		

/**
 * 返回好友请求
 */
  function listsql_request($uid)
  {
		$this->db->select('*');
		$this->db->from('friends');
		$this->db->where('uid',$uid);
		$this->db->where('isok',0);
		$this->db->where('isblack',0);
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
  }	
  
/**
 * 返回黑名单列表
 */
  function listsql_black($uid)
  {
		$this->db->select('*');
		$this->db->from('friends');
		$this->db->where('uid',$uid);
		$this->db->where('isblack',1);
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
  }	


  
/**
 * 用户页面(我的好友)
 */
  function User_Friends1($uid)
  {
		$this->db->select('friends.fuid,user.name,user.photoID,user.addtime');
		$this->db->from('friends');
		$this->db->join('user','friends.fuid=user.id','left');
		$this->db->where('friends.uid',$uid);
		$this->db->where('friends.u_del',0);
		$this->db->limit(5);
		return $this->db->get()->result();
  }	
  function User_Friends2($uid)
  {
		$this->db->select('friends.uid,user.name,user.photoID,user.addtime');
		$this->db->from('friends');
		$this->db->join('user','friends.fuid=user.id','left');
		$this->db->where('friends.fuid',$uid);
		$this->db->where('friends.su_del',0);
		$this->db->limit(5);
		return $this->db->get()->result();
  }

  
/**
 * 增加好友用户
 */
	function add($data='')
	{
    	return $this->db->insert('friends',$data);
	}
	
/**
 * 限制只增加一位好友用户
 */
	function add_one($uid=0,$uid2=0)
	{
		if( $this->is_friends($uid,$uid2) == false )
		{
			$data = array(
				  'uid' => $uid ,
				  'fuid' => $uid2
				  );
			$this->add($data);
			return true;
		}
		return false;
	}
	
  
  
/**
 * 判断是否已经收藏
 */
  function is_friends($uid=0,$uid2=0)
  {
  	    $this->db->from('friends');
    	$this->db->where('uid', $uid);
		$this->db->where('fuid', $uid2);
		
    	if($this->db->count_all_results()<=0)
    	{
    		return false;
    	}
    	return true;
  }

  
/**
 * 删除数据
 */
  function del($id=0,$uid=0)
  {
    	$this->db->where('uid', $uid);
		$this->db->where('id', $id);
		$this->db->where('isok', 1);
    	return $this->db->delete('friends'); 
  }

  
/**
 * 删除黑名单数据
 */
  function del_black($id=0,$uid=0)
  {
    	$this->db->where('uid', $uid);
		$this->db->where('id', $id);
		$this->db->where('isblack', 1);
    	return $this->db->delete('friends'); 
  }

}
?>