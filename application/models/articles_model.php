<?php
#淘工会信息

class Articles_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回sql(用于工会页面 /articles 列表数据)
	function get_sql($typeid=0)
	{
		if(is_num($typeid)){
			return "select A.id,A.title,A.type_id,A.time,B.t_id,B.t_title,B.t_order_id from articles A left join articles_type B on A.type_id=B.t_id where A.type_id=".$typeid." order by A.id desc";
		}else{
			return "select A.id,A.title,A.type_id,A.time,B.t_id,B.t_title,B.t_order_id from articles A left join articles_type B on A.type_id=B.t_id order by A.id desc";
		}
	}
	
	//返回分类
	function get_types()
	{
		return $this->db->query("select t_id,t_title,t_order_id from articles_type order by t_order_id desc,t_id desc")->result();
	}
	
	//返回分类数目
	function get_types_num()
	{
		return $this->db->query("select t_id from articles_type")->num_rows();
	}

	//返回分类
	function get_type($id)
	{
		return $this->db->query("select t_id,t_title,t_order_id from articles_type where t_id=".$id)->row();
	}
	
	//文章点击+1
	function hit($id=0)
	{
		$this->db->query("update articles set visited=visited+1 where id=".$id);
	}
	
	//返回文章内容详情
	function view($id=0)
	{
		return $this->db->query("select A.title,A.type_id,A.time,A.visited,A.content,B.t_id,B.t_title from articles A left join articles_type B on A.type_id=B.t_id where A.id=".$id)->row();
	}
	
	
	//删除文章内容
	function del($id)
	{
		return $this->db->query("delete from articles where id=".$id);
	}
	
	//删除分类
	function del_type($id)
	{
		return $this->db->query("delete from articles_type where t_id=".$id);
	}
	
}
?>