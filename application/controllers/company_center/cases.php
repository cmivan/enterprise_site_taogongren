<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cases extends COMPANY_Controller {

	public $type_id = 1; //1为案例 2为证书
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Case_Model');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '管理案例','link' => 'index'),
					array('title' => '添加案例','link' => 'add')
		            );
	}
	
	
	
	function index()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id)
		{
			$this->Case_Model->del($del_id,$this->type_id,$this->logid);
		}

		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->Case_Model->listsql($this->logid,$this->type_id,0);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		/*输出到视窗*/
		$this->load->view_company('cases/index',$this->data);
	}
	
	
	function add()
	{
		$this->load->library('kindeditor');
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_company('cases/add',$this->data);
	}	

	function edit($id='')
	{
		$this->load->library('kindeditor');
		//安全处理
		$id = get_num($id,'');
		//获取当前编辑项信息
		$this->data["info"] = $this->Case_Model->view($id,$this->logid);
		//评论邀请链接
		$this->data["case_link"] = case_link($id); 
		
		//防止空数据
		if(empty($this->data["info"])){ show_404(); }
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_company('cases/edit',$this->data);
	}


	function save($id='')
	{
		//安全处理
		$id = get_num($id);
		//保存数据(添加/编辑)
		$this->Case_Model->save($id,$this->type_id,$this->logid);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */