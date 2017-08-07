<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Recruitment_Model');
		$this->load->model('Industry_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '发布招聘信息','link' => 'add_invite'),
					array('title' => '发布求职信息','link' => 'add_job'),
					array('title' => '管理求职/招聘','link' => 'manage')
		            );

		//个人信息
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		//获取工种
		$this->data["industrys"] = $this->Industry_Model->industrys();
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/manage';
		
		/*<><><>css样式<><><>*/
		//$this->data['cssfiles'][] = 'style/page_user_employer.css';
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		/*<><><>Js<><><>*/
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
	}
	
	
	function index()
	{
		//控制器默认指向
		$this->add_invite();
	}
	
	
	
	function manage()
	{
		
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
		   $this->Recruitment_Model->del($del_id,$this->logid);
		}

		//获取分页列表sql
		$this->load->library('Paging');
		$listsql=$this->Recruitment_Model->listsql($this->logid);
		$this->data["list"] = $this->paging->show($listsql);
		
		//输出到视窗
		$this->load->view_wuser('recruitment/index',$this->data);
	}
	
	//页面-添加求职
	function add_job()
	{
		$this->load->library('kindeditor');
		
		$this->data["types"] = $this->Recruitment_Model->types();

		//输出到视窗
		$this->load->view_wuser('recruitment/add_job',$this->data);
	}	
	
	//页面-添加招聘
	function add_invite()
	{
		$this->load->library('kindeditor');
		
		$this->data["types"] = $this->Recruitment_Model->types();

		//输出到视窗
		$this->load->view_wuser('recruitment/add_invite',$this->data);
	}	
	
	//编辑
	function edit($id='')
	{
		$this->load->library('kindeditor');
		
		//安全处理
		$id = get_num($id,'404');
		
		$type_id = $this->Recruitment_Model->type_id($id);
		
		//获取分类
		$this->data["types"] = $this->Recruitment_Model->types();
		//获取当前编辑项信息
		$this->data["info"]  = $this->Recruitment_Model->view($id,$this->logid);
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;

		//输出到视窗
		if($type_id==1)
		{
			$this->load->view_wuser('recruitment/edit_invite',$this->data);
		}
		else
		{
			$this->load->view_wuser('recruitment/edit_job',$this->data);	
		}
		
	}

	
	function save($id='')
	{
		//安全处理
		$id = get_num($id);
		//保存数据(添加/编辑)
		$this->Recruitment_Model->save($id,$this->logid);
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */