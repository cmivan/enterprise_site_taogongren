<?php
#广告

class Ads_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回所有广告位置
	function ad_sets()
	{
	    $this->db->select('*');
    	$this->db->from('ad_set');
    	$this->db->order_by('order_id','desc');
		$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}
	
	//返回指定页面的所有广告位置
	function ad_page_sets($page_id=0)
	{
	    $this->db->select('id');
    	$this->db->from('ad_set');
    	$this->db->where('page_id',$page_id);
    	return $this->db->get()->result();
	}
	
	
	//返回广告位置总数目
	function ad_sets_num()
	{
    	return $this->db->count_all_results('ad_set');
	}
	
	//返回广告位置详情
	function ad_set_view($id,$show=0)
	{
	    $this->db->select('*');
    	$this->db->from('ad_set');
    	$this->db->where('id',$id);
    	if($show==1)
    	{
    		$this->db->where('isshow',1);
    	}
    	return $this->db->get()->row();
	}
	
	//返回广告数目
	function ad_lists_num($set_id=0)
	{
		$this->db->from('ad_list');
		if(is_num($set_id))
		{
			$this->db->where('set_id',$set_id);
		}
		return $this->db->count_all_results();
	}
	
	//返回进行中的广告
	function ad_ing($set_id=0)
	{
		if(is_num($set_id))
		{
			$this->db->select('uid,ad_file,ad_type,link');
			$this->db->from('ad_list');
			$this->db->where("unix_timestamp(date_go)<".time()." and unix_timestamp(date_end)>".time());
			$this->db->where('set_id',$set_id);
			return $this->db->get()->row();
		}
	}
	
	//返回广告进行中的数目
	function ad_set_ing($set_id=0)
	{
		$this->db->from('ad_list');
		$this->db->where("unix_timestamp(date_go)<".time()." and unix_timestamp(date_end)>".time());
		if(is_num($set_id))
		{
			$this->db->where('set_id',$set_id);
		}
		if( $this->db->count_all_results() > 0)
		{
			return true;
		}
		return false;
	}
	
	//返回广告已完成数目
	function ad_lists_ok_num($set_id=0)
	{
		$this->db->from('ad_list');
		$this->db->where("unix_timestamp(date_end)<".time());
		if(is_num($set_id))
		{
			$this->db->where('set_id',$set_id);
		}
		return $this->db->count_all_results();
	}
	//返回广告等待开始的数目
	function ad_lists_waitting_num($set_id=0)
	{
		$this->db->from('ad_list');
		$this->db->where("unix_timestamp(date_go)>".time());
		if(is_num($set_id))
		{
			$this->db->where('set_id',$set_id);
		}
		return $this->db->count_all_results();
	}
	
	//文章点击+1
	function hit($id=0)
	{
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('ad_list',array());
	}
	
	//返回广告详情
	function view($id=0)
	{
		$this->db->select('ad_list.*,ad_set.*');
		$this->db->from('ad_list');
		$this->db->join('ad_set','ad_list.set_id=ad_set.id','left');
		$this->db->where('ad_list.id', $id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
	
	//返回广告位置
	function ad_pages()
	{
	    $this->db->select('*');
    	$this->db->from('ad_page');
		$this->db->order_by('order_id','desc');
		$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}
	
	//返回广告位置总数目
	function ad_pages_num()
	{
		return $this->db->count_all_results('ad_page');
	}
	
	//返回广告位置详情
	function ad_page_view($id)
	{
	    $this->db->select('*');
    	$this->db->from('ad_page');
    	$this->db->where('id',$id);
    	return $this->db->get()->row();
	}
	
	
	//删除广告
	function del($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('ad_list');
	}
	
	//删除广告位
	function del_type($id)
	{
    	$this->db->where('id', $id);
    	return $this->db->delete('ad_set');
	}

	
}
?>