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
    	$this->db->where('uid', $logid);
		$this->db->where('gid', $uid);
    	$this->db->from('get_mobile');
    	if($this->db->count_all_results()<=0)
    	{
    		return false;
    	}
    	return true;
	}
	
	
/**
 * 增加查看记录
 */	
	function add($data='')
	{
    	return $this->db->insert('get_mobile',$data);
	}
	
	
}
?>