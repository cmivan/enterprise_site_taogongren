<?php
#淘工会信息

class System_user_Model extends CI_Model {

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
		return $this->db->query("select t_id,t_title,t_order_id from articles_type order by t_id asc")->result();
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
		return $this->db->query("select * from km_admin where id=".$id)->row();
	}
	
	
	//删除帐号
	function del($id)
	{
		return $this->db->query("delete from km_admin where super<>1 and id=".$id);
	}

	
}
?>