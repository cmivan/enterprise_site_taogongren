<?php
#单用户信息

class Approve_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

/**
 * 返回年限查询sql
 */
    function age_sql($id=0)
    {
	    $this->db->select('id,sqlstr');
    	$this->db->from('age_class');
    	$this->db->where('id',$id);
		$this->db->limit(1);
    	$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->sqlstr;
		}
		return NULL;
    }
	
/**
 * 返回认证类型的sql
 */
    function approve_sql($id=0)
    {
	    $this->db->select('id,sqlstr');
    	$this->db->from('approve_class');
    	$this->db->where('id',$id);
		$this->db->limit(1);
    	$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->sqlstr;
		}
		return NULL;
    }
	
    function approve_key($id=0)
    {
	    $key = $this->approve_sql($id);
		if(!empty($key))
		{
			return str_replace('=1','',$key);
		}
		return NULL;
    }

	

}
?>