<?php
#文章信息

class Articles_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
    /*返回sql(用于工会页面 /articles 列表数据)*/
	function get_sql($typeid=0)
	{
		$this->db->select('articles.id,articles.title,articles.type_id,articles.time,articles_type.t_id,articles_type.t_title,articles_type.t_order_id');
		$this->db->from('articles');
		$this->db->join('articles_type','articles.type_id = articles_type.t_id','left');
		$this->db->order_by('articles.id','desc');
		if(is_num($typeid))
		{
			$this->db->where('articles.type_id', $typeid);
		}
		//返回SQL
		return $this->db->getSQL();
	}
	
	/*返回分类*/
	function get_types()
	{
	    $this->db->select('t_id,t_title,t_order_id');
    	$this->db->from('articles_type');
    	$this->db->order_by('t_order_id','desc');
    	$this->db->order_by('t_id','desc');
    	return $this->db->get()->result();
	}
	
	/*返回分类数目*/
	function get_types_num()
	{
    	return $this->db->count_all_results('articles_type');
	}

	/*返回分类*/
	function get_type($id)
	{
	    $this->db->select('t_id,t_title,t_order_id');
    	$this->db->from('articles_type');
    	$this->db->where('t_id',$id);
    	return $this->db->get()->row();
	}
	
	/*文章点击+1*/
	function hit($id=0)
	{
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('articles',array());
	}
	
	/*返回分类*/
	function list_hot($num=10)
	{
	    $this->db->select('id,title,visited');
    	$this->db->from('articles');
    	$this->db->order_by('visited','desc');
		$this->db->limit($num);
    	return $this->db->get()->result();
	}

	/*返回文章内容详情*/
	function view($id=0)
	{
	    $this->db->select('articles.title,articles.type_id,articles.time,articles.visited,articles.content,articles_type.t_id,articles_type.t_title');
    	$this->db->from('articles');
    	$this->db->join('articles_type','articles.type_id = articles_type.t_id','left');
    	$this->db->where('articles.id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	
	//删除文章内容
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('articles'); 
	}
	
	/*删除分类*/
	function del_type($id)
	{
    	$this->db->where('t_id', $id);
    	return $this->db->delete('articles_type'); 
	}

}
?>