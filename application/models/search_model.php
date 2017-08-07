<?php
class Search_model extends CI_Model {
	
	/*搜索页面所有参数 */
    function __construct()
    {
        parent::__construct();

		$team_or_men = $this->input->get("team_or_men", TRUE);
		$industryid  = $this->input->get("industryid", TRUE);
		$classid     = $this->input->get("classid", TRUE);
		$hot_skills  = $this->input->get("hot_skills", TRUE);
		$skills      = $this->input->get("skills", TRUE);
		$age         = $this->input->get("age", TRUE);
		$approve     = $this->input->get("approve", TRUE);
		$keyword     = $this->input->get("keyword", TRUE);
		$page        = $this->input->get("page", TRUE);
    }

	
	/*用户等级*/
	function levels()
	{
	    $this->db->select('*');
    	$this->db->from('level_class');
    	$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}

	
	/*用户年龄*/
	function ages()
	{
	    $this->db->select('*');
    	$this->db->from('age_class');
    	$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}
	
	
	/*用户认证*/
	function approves()
	{
	    $this->db->select('*');
    	$this->db->from('approve_class');
    	$this->db->order_by('id','desc');
    	return $this->db->get()->result();
	}
	
}
?>