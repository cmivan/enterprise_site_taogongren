<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certificate extends W_Controller {

	public $type_id = 2; //1为案例 2为证书

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		$this->load->model('Case_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '管理证书','link' => 'index'),
					array('title' => '添加证书','link' => 'add')
		            );

		//工人类型(工人或团队)
		$this->data['worker_types'] = $this->User_Model->worker_types();

		//初始化上传路径
		$this->data["uploads_url"] = $this->config->item('uploads_url');
	}
	
	
	
	function index($is_team=0)
	{
		
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Case_Model->del($del_id,$this->type_id,$this->logid);
		}
		
		//查看案例的类型（个人，团队）
		$is_team = get_num($is_team,0);
		$this->data['is_team'] = $is_team;
		
		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->Case_Model->listsql($this->logid,$this->type_id,$is_team);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('certificate/index',$this->data);
	}
	
	
	function add()
	{
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		//输出到视窗
		$this->load->view_wuser('certificate/add',$this->data);
	}	
	
	
	
	function edit($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//获取当前编辑项信息
		$this->data["info"] = $this->Case_Model->view($id,$this->logid);
		//防止空数据
		if(empty($this->data["info"])){show_404();}
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		//输出到视窗
		$this->load->view_wuser('certificate/edit',$this->data);
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