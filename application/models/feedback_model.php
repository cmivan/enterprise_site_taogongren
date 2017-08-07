<?php
#淘工会信息

class Feedback_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回sql(用于页面 /Sys_page 列表数据)
	function get_sql()
	{
	    $this->db->select('*');
    	$this->db->from('feedback');
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}
	
	//返回内容详情
	function view($id=0)
	{
	    $this->db->select('*');
    	$this->db->from('feedback');
    	$this->db->where('id',$id);
		$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	//增加留言
	function add($data='')
	{
    	return $this->db->insert('feedback',$data);
	}
	
	//删除
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('feedback');
	}
	
}
?>