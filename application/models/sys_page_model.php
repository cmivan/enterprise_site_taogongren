<?php
#其他页面信息

class Sys_page_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
    
	/*返回sql(用于页面 /Sys_page 列表数据)*/
	function get_sql()
	{
		$this->db->select('*');
		$this->db->from('sys_page');
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}
	
	
	/*内容详情*/
	function view($id=0)
	{
	    $this->db->select('*');
    	$this->db->from('sys_page');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	
	/*删除内容*/
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('sys_page');
	}
	
}
?>