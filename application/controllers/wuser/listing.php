<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listing extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Listing_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '管理排期','link' => 'index'),
					array('title' => '添加排期','link' => 'add')
		            );
	}
	


	function index()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
		   $this->Listing_Model->del($del_id,$this->logid);
		}

		//分页模型
		$this->load->library('Paging');
		$listsql=$this->Listing_Model->listsql($this->logid);
		$this->data["list"] = $this->paging->show($listsql);

		//输出到视窗
		$this->load->view_wuser('listing/index',$this->data);
	}
	
	
	function add()
	{
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view_wuser('listing/add',$this->data);
	}	
	

	
	function edit($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//获取当前编辑项信息
		$this->data["info"]  = $this->Listing_Model->view($id,$this->logid);
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		$this->load->view_wuser('listing/edit',$this->data);
	}
	

	
	function save($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//保存数据(添加/编辑)
		$this->Listing_Model->save($id,$this->logid);
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */