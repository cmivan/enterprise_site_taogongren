<?php
#广告

class Ads_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//返回广告位置
	function ad_sets()
	{
		return $this->db->query("select * from ad_set order by order_id desc,id desc")->result();
	}
	
	//返回广告位置总数目
	function ad_sets_num()
	{
		return $this->db->query("select id from ad_set")->num_rows();
	}
	
	//返回广告位置详情
	function ad_set_view($id)
	{
		return $this->db->query("select * from ad_set where id=".$id)->row();
	}
	
	//返回广告数目
	function ad_lists_num($set_id=0)
	{
		if(is_num($set_id)){ $where = ' where set_id='.$set_id; }else{ $where = ''; }
		return $this->db->query("select id from ad_list".$where)->num_rows();
	}
	
	//返回广告进行中的数目
	function ad_set_ing($set_id=0)
	{
		if(is_num($set_id)){ $where = ' and set_id='.$set_id; }else{ $where = ''; }
	    $num=$this->db->query("select id from ad_list where unix_timestamp(date_go)<".time()." and unix_timestamp(date_end)>".time().$where)->num_rows();
		if($num>0){return true;}else{return false;}
	}
	//返回广告已完成数目
	function ad_lists_ok_num($set_id=0)
	{
		if(is_num($set_id)){ $where = ' and set_id='.$set_id; }else{ $where = ''; }
		return $this->db->query("select id from ad_list where unix_timestamp(date_end)<".time().$where)->num_rows();
	}
	//返回广告等待开始的数目
	function ad_lists_waitting_num($set_id=0)
	{
		if(is_num($set_id)){ $where = ' and set_id='.$set_id; }else{ $where = ''; }
		return $this->db->query("select id from ad_list where unix_timestamp(date_go)>".time().$where)->num_rows();
	}
	

	
	//文章点击+1
	function hit($id=0)
	{
		$this->db->query("update ad_list set visited=visited+1 where id=".$id);
	}
	
	//返回文章内容详情
	function view($id=0)
	{
		return $this->db->query("select A.*,B.* from ad_list A left join ad_set B on A.set_id=B.id where A.id=".$id)->row();
	}
	
	
	//返回广告位置
	function ad_pages()
	{
		return $this->db->query("select * from ad_page order by order_id desc,id desc")->result();
	}
	
	//返回广告位置总数目
	function ad_pages_num()
	{
		return $this->db->query("select id from ad_page")->num_rows();
	}
	
	//返回广告位置详情
	function ad_page_view($id)
	{
		return $this->db->query("select * from ad_page where id=".$id)->row();
	}
	
	
	//删除广告
	function del($id)
	{
		return $this->db->query("delete from ad_list where id=".$id);
	}
	
	//删除广告位
	function del_type($id)
	{
		return $this->db->query("delete from ad_set where id=".$id);
	}

	
}
?>