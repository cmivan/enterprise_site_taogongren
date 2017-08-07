<?php
#单用户信息

class Retrieval_election_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	
	//删除内容
	function del($id)
	{
		return $this->db->query("delete from retrieval_election where id=".$id);
	}

}
?>