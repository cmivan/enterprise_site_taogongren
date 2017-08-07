<?php
class Searchs extends CI_Model {

	
/**
 * 搜索页面所有参数 
 */
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

	
	/*
	 * 用户等级
	 * */
	function levels()
	{
		return $this->db->query("select * from level_class order by id asc")->result();
	}

	
	/*
	 * 用户年龄
	 * */
	function ages()
	{
		return $this->db->query("select * from age_class order by id asc")->result();
	}
	
	
	/*
	 * 用户认证
	 * */
	function approves()
	{
		return $this->db->query("select * from approve_class order by id asc")->result();
	}
	
}
?>