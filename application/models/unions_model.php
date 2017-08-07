<?php
#淘工会信息

class Unions_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
    /*返回sql(用于工会页面 /unions 列表数据)*/
	function get_sql($typeid=0)
	{
		$this->db->select('unions.id,unions.title,unions.type_id,unions.time,unions_type.t_id,unions_type.t_title,unions_type.t_order_id');
		$this->db->from('unions');
		$this->db->join('unions_type','unions.type_id = unions_type.t_id','left');
		$this->db->order_by('unions.id','desc');
		if(is_num($typeid))
		{
			$this->db->where('unions.type_id', $typeid);
		}
		//返回SQL
		return $this->db->getSQL();
	}
	
	/*返回分类*/
	function get_types()
	{
	    $this->db->select('t_id,t_title,t_order_id');
    	$this->db->from('unions_type');
    	$this->db->order_by('t_order_id','desc');
    	$this->db->order_by('t_id','desc');
    	return $this->db->get()->result();
	}
	
	/*返回分类数目*/
	function get_types_num()
	{
    	return $this->db->count_all_results('unions_type');
	}

	/*返回分类*/
	function get_type($id)
	{
	    $this->db->select('t_id,t_title,t_order_id');
    	$this->db->from('unions_type');
    	$this->db->where('t_id',$id);
    	return $this->db->get()->row();
	}
	
	/*文章点击+1*/
	function hit($id=0)
	{
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('unions',array());
	}
	
	
	/*返回分类*/
	function list_hot($num=10)
	{
	    $this->db->select('id,title,visited');
    	$this->db->from('unions');
    	$this->db->order_by('visited','desc');
		$this->db->limit($num);
    	return $this->db->get()->result();
	}
	
	/*返回文章内容详情*/
	function view($id=0)
	{
	    $this->db->select('unions.title,unions.type_id,unions.time,unions.visited,unions.content,unions_type.t_id,unions_type.t_title');
    	$this->db->from('unions');
    	$this->db->join('unions_type','unions.type_id = unions_type.t_id','left');
    	$this->db->where('unions.id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
	}
	
	//删除文章内容
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('unions'); 
	}
	
	/*删除分类*/
	function del_type($id)
	{
    	$this->db->where('t_id', $id);
    	return $this->db->delete('unions_type'); 
	}

}
?>