<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Skills_Model');
		$this->load->model('Industry_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '我擅长的技能清单','link' => 'index','tip' => '点击相应的项目可以添加报价'),
					array('title' => '管理擅长技能','link' => 'skills_management','tip' => '在这里可以 添加/删除 你擅长的技能'),
					array('title' => '参考报价','link' => 'prices')
		            );
	}
	
	
	
	function index()
	{
		//用户技能总数
		$this->data["skills_count"] = $this->Industry_Model->skills_count($this->logid);
		//用户擅长工种
		$this->data["goodat_industrys"] = $this->Industry_Model->goodat_industrys($this->logid);
		//用户擅长项目种类
		$this->data["goodat_classes"] = $this->Industry_Model->goodat_classes($this->logid);
		//用户擅长项目种类
		//goodat_class_industrys($classid,$logid);

		//输出到视窗
		$this->load->view_wuser('projects/index',$this->data);
	}
	
	
	
	function skills_management()
	{
		$this->data["industrys"] = $this->Industry_Model->industrys();
		$this->data["industry_class"] = $this->Industry_Model->industry_class();
		//用户技能
		$this->data["goodat_skills"] = $this->Industry_Model->goodat_skills($this->logid,500);
		//用户技能总数
		$this->data["skills_count"] = $this->Industry_Model->skills_count($this->logid);
		
		
		
		//用户擅长工种
		$this->data["goodat_industrys"] = $this->Industry_Model->goodat_industrys($this->logid);
		//用户擅长项目种类
		$this->data["goodat_classes"] = $this->Industry_Model->goodat_classes($this->logid);
		//输出到视窗
		$this->load->view_wuser('projects/skills_management',$this->data);
	}
	
	
	
	function prices()
	{
		//删除报价
		$del_id = $this->input->getnum("del_id");
		if( $del_id )
		{
			$thisdata["price"] = 0;
			$thisdata["note"]  = '';
			$this->db->where('workerid',$this->logid);
			$this->db->where('id',$del_id);
			$this->db->update('skills', $thisdata); 
		}
		
		//读取列表
		$this->load->library('Paging');
		$listsql = $this->Skills_Model->user_skill_prices_sql( $this->logid );
	    $this->data["list"] = $this->paging->show( $listsql ,10);
		//输出到视窗
		$this->load->view_wuser('projects/prices',$this->data);
	}

	
	function add()
	{
		$pro_id = $this->input->getnum("pro_id",0);
		$this->data["projects"] = $this->Skills_Model->user_skill_view( $this->logid , $pro_id );
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		//输出到视窗
		$this->load->view_wuser('projects/edit',$this->data);
	}
	
	function edit()
	{
		$pro_id = $this->input->getnum("pro_id",0);
		$this->data["projects"] = $this->Skills_Model->user_skill_view( $this->logid , $pro_id );
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/prices';
		//输出到视窗
		$this->load->view_wuser('projects/edit',$this->data);
	}
	
	
	
	function save()
	{
		$pro_id = $this->input->postnum("pro_id");
		if($pro_id == false)
		{
			json_form_no('提交失败,无法正确获取项目ID,请与管理员联系!');
		}
		else
		{
			$data["note"] = $this->input->post("note",true);
			$data["price"] = $this->input->post("price",true);
			if($data["price"]!=""&&$data["note"]!="")
			{
				$this->db->where('workerid',$this->logid);
				$this->db->where('id',$pro_id);
				$this->db->update('skills', $data);
				json_form_yes('保存成功!');
		    }
		    else
			{
				json_form_no('请先完整填写信息!');
		    }
		}
	}
	
	
	function checked_one()
	{
		$this->load->model('Skills_Model');
		
		$checked = $this->input->get("checked");
		$industryid = $this->input->getnum("industryid",0);
		
		if($checked==0)
		{
		   //删除擅长技能
		   $this->Skills_Model->skills_del($this->logid,$industryid);
		   json_echo('0');
		}
		elseif($checked==1)
		{
			//判断未添加某擅长技能则添加
			if( $this->Skills_Model->user_skill_added($this->logid,$industryid) == false )
			{
				$this->Skills_Model->user_skill_add($this->logid,$industryid);
				json_echo("1");
		    }
		}
		
	}
	
	
	function checked_all()
	{
		$this->load->model('Skills_Model');
		
		$checked = $this->input->get("checked");
		$classid = $this->input->getnum("classid",0);
		$industryid = $this->input->getnum("industryid",0);
		
		//获取旗下的技能
		$cis = $this->Industry_Model->class_industrys($classid,$industryid);
		if( !empty($cis) )
		{
			if($checked==0)
			{
				foreach($cis as $rs)
				{
					//删除擅长技能
					$this->Skills_Model->skills_del($this->logid,$rs->id);
				}
				json_echo("0");
			}
			elseif($checked==1)
			{
				foreach($cis as $rs)
				{
					//判断未添加某擅长技能则添加
					if( $this->Skills_Model->user_skill_added( $this->logid , $rs->id ) == false )
					{
						$this->Skills_Model->user_skill_add( $this->logid , $rs->id );
					}
				}
				json_echo("1");
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */