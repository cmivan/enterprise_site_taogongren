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
		return "select * from feedback order by id desc";
	}
	
	//返回文章内容详情
	function view($id=0)
	{
		return $this->db->query("select * from feedback where id=".$id)->row();
	}
	
	//删除文章内容
	function del($id)
	{
		return $this->db->query("delete from feedback where id=".$id);
	}
	
}
?>