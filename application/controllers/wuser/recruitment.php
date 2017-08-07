<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment extends W_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Recruitment_Model');
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "发布招聘信息";
		$this->data["thisnav"]["nav"][0]["link"]  = "add_invite";
		$this->data["thisnav"]["nav"][1]["title"] = "发布求职信息";
		$this->data["thisnav"]["nav"][1]["link"]  = "add_job";
		$this->data["thisnav"]["nav"][2]["title"] = "管理求职/招聘";
		$this->data["thisnav"]["nav"][2]["link"]  = "manage";

		/*个人信息*/
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		$this->data["industrys"] = $this->db->query("select id,title from `industry` where industryid=0 order by id asc")->result();

		/*表单配置*/
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
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
		   $this->Recruitment_Model->del($del_id,$this->logid);
		}

		//获取分页列表sql
		$this->load->model('Paging');
		$listsql=$this->Recruitment_Model->listsql($this->logid);
		$this->data["list"] = $this->Paging->show($listsql);
		
		/*输出到视窗*/
		$this->load->view_wuser('recruitment/index',$this->data);
	}
	
	//页面-添加求职
	function add_job()
	{
		$this->load->library('kindeditor');
		
		$this->data["types"] = $this->Recruitment_Model->types();

		/*输出到视窗*/
		$this->load->view_wuser('recruitment/add_job',$this->data);
	}	
	
	//页面-添加招聘
	function add_invite()
	{
		$this->load->library('kindeditor');
		
		$this->data["types"] = $this->Recruitment_Model->types();

		/*输出到视窗*/
		$this->load->view_wuser('recruitment/add_invite',$this->data);
	}	
	
	//编辑
	function edit($id=0)
	{
		$this->load->library('kindeditor');
		
		//安全处理
		$id = is_num($id,'404');
		
		$type_id = $this->Recruitment_Model->type_id($id);
		
		//获取分类
		$this->data["types"] = $this->Recruitment_Model->types();
		//获取当前编辑项信息
		$this->data["info"]  = $this->Recruitment_Model->view($id,$this->logid);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;

		/*输出到视窗*/
		if($type_id==1){
			$this->load->view_wuser('recruitment/edit_invite',$this->data);
		}else{
			$this->load->view_wuser('recruitment/edit_job',$this->data);	
		}
		
	}

	
	function save($id=0)
	{
		//安全处理
		$id = is_num($id);
		//保存数据(添加/编辑)
		$this->Recruitment_Model->save($id,$this->logid);
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */