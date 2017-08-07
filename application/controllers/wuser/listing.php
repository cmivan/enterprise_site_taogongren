<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listing extends W_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Listing_Model');
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "管理排期";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][1]["title"] = "添加排期";
		$this->data["thisnav"]["nav"][1]["link"]  = "add";
	}
	


	function index()
	{
		
		//删除数据
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
		   $this->Listing_Model->del($del_id,$this->logid);
		}

		//分页模型
		$this->load->model('Paging');
		$listsql=$this->Listing_Model->listsql($this->logid);
		$this->data["list"] = $this->Paging->show($listsql);

		/*输出到视窗*/
		$this->load->view_wuser('listing/index',$this->data);
	}
	
	
	function add()
	{
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_wuser('listing/add',$this->data);
	}	
	

	
	function edit($id=0)
	{
		//安全处理
		$id = is_num($id,0);
		//获取当前编辑项信息
		$this->data["info"]  = $this->Listing_Model->view($id,$this->logid);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		$this->load->view_wuser('listing/edit',$this->data);
	}
	

	
	function save($id=0)
	{
		//安全处理
		$id = is_num($id,0);
		//保存数据(添加/编辑)
		$this->Listing_Model->save($id,$this->logid);
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */