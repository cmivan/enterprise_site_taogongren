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
		$rs = $this->db->query("select id,sqlstr from `age_class` where id=$id LIMIT 1")->row();
		if(!empty($rs))
		{
			return $rs->sqlstr;
		}else{
			return "";
		}
    }
	
/**
 * 返回认证类型的sql
 */
    function approve_sql($id=0)
    {
		$rs = $this->db->query("select id,sqlstr from `approve_class` where id=$id LIMIT 1")->row();
		if(!empty($rs))
		{
			return $rs->sqlstr;
		}else{
			return "";
		}
    }
	

	

}
?>