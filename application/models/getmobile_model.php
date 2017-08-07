<?php
#获取手机信息记录

class GetMobile_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
/**
 * 用户是否已经获取指定用的手机
 */	
	function is_getok($logid=0,$uid=0)
	{
		return $this->db->query("select id from get_mobile where uid=".$logid." and gid=".$uid." LIMIT 1")->num_rows();
	}

	
	
}
?>