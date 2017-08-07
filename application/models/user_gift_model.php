<?php
#单用户信息

class User_gift_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*是否已对指定用户赠送*/
    function is_gift($uid=0)
    {
		$this->db->from('user_gift_ok');
		$this->db->where('uid',$uid);
		$this->db->limit(1);
		if($this->db->count_all_results()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
    }
	
    /*是否已对指定用户赠送*/
    function add_gift($data=0)
    {
		return $this->db->insert('user_gift_ok', $data);
    }
	
    /*删除已对指定用户赠送的记录*/
    function del_gift($uid=0)
    {
		$this->db->where('uid',$uid);
		$this->db->where('ok !=',1);
		return $this->db->delete('user_gift_ok');
    }
	
	
	

}
?>