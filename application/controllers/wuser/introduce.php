<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Introduce extends W_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		$this->load->model('Introduce_Model');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '我已经介绍的好友','link' => 'index'),
					array('title' => '我要介绍好友','link' => 'add')
		            );
	}
	


	function index()
	{
		
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Introduce_Model->del($del_id,$this->logid);
		}
		
		
		//获取分页列表sql
		$this->load->library('Paging');
		$listsql=$this->Introduce_Model->listsql($this->logid);
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('introduce/index',$this->data);
	}
	
	
	function add()
	{
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view_wuser('introduce/add',$this->data);
	}	
	
	
	function edit($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//获取当前编辑项信息
		$this->data["info"]  = $this->Introduce_Model->view($id,$this->logid);
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];

		//输出到视窗
		$this->load->view_wuser('introduce/edit',$this->data);
	}	
	
	
	
	function save($id='')
	{
		//安全处理
		$id = get_num($id);
		//保存数据(添加/编辑)
		$this->Introduce_Model->save($id,$this->logid);
	}
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */