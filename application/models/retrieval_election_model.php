<?php
#投标评论

class Retrieval_election_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//通过任务信息,获取用户等信息
	function view($id=0)
	{
		$this->db->select('id,retrievalid,uid');
		$this->db->from('retrieval_election');
		$this->db->where('id',$id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
	//设置该工人为任务选中人
	function set_seleted($uid=0,$retrievalid=0)
	{
		$this->db->set('ok',1);
		$this->db->where('uid',$uid);
		$this->db->where('retrievalid',$retrievalid);
		return $this->db->update('retrieval_election');
	}

	//更新数据
	function update($data)
	{
		return $this->db->update('retrieval_election',$data);
	}

	
	//删除内容
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('retrieval_election');
	}

}
?>