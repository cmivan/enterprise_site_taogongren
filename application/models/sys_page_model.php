<?php
#淘工会信息

class Sys_page_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回sql(用于页面 /Sys_page 列表数据)
	function get_sql()
	{
		return "select * from sys_page order by id desc";
	}
	
	//返回文章内容详情
	function view($id=0)
	{
		return $this->db->query("select * from sys_page where id=".$id)->row();
	}
	
	
	//删除文章内容
	function del($id)
	{
		return $this->db->query("delete from sys_page where id=".$id);
	}
	
}
?>