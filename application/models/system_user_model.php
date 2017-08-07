<?php
#系统用户信息

class System_user_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/*返回详情*/
	function view($id=0)
	{
	    $this->db->select('*');
    	$this->db->from('km_admin');
    	$this->db->where('id',$id);
		$this->db->limit(1);
    	return $this->db->get()->row();
	}

	/*删除帐号*/
	function del($id)
	{
    	$this->db->where('super !=', 1);
    	$this->db->where('id', $id);
    	return $this->db->delete('km_admin');
	}

	
}
?>