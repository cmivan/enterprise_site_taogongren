<?php
#收藏用户

class Favorites_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($uid)
  {
	    $this->db->select('*');
    	$this->db->from('favorites');
    	$this->db->where('uid',$uid);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
  }		
	
	
/**
 * 增加收藏用户
 */
	function add($data='')
	{
    	return $this->db->insert('favorites',$data);
	}
	
/**
 * 限制只增加一位收藏用户
 */
	function add_one($uid=0,$uid2=0)
	{
		if( $this->is_favorites($uid,$uid2) == false )
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
 * 删除数据
 */
  function del($id=0,$uid=0)
  {
    	$this->db->where('uid', $uid);
		$this->db->where('id', $id);
    	return $this->db->delete('favorites'); 
  }
  
  
/**
 * 判断是否已经收藏
 */
  function is_favorites($uid=0,$uid2=0)
  {
  	    $this->db->from('favorites');
    	$this->db->where('uid', $uid);
		$this->db->where('fuid', $uid2);
		
    	if($this->db->count_all_results()<=0)
    	{
    		return false;
    	}
    	return true;
  }


}
?>