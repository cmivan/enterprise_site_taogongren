<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends W_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $thisnav;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('TeamAd_Model');
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "管理广告";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][1]["title"] = "发布广告";
		$this->data["thisnav"]["nav"][1]["link"]  = "add";
	}
	
	
	
	function index()
	{
		//分页模型
		$this->load->model('Paging');
		//获取分页列表sql
		$listsql=$this->TeamAd_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql);
		/*输出到视窗*/
		$this->load->view_wuser('ads/index',$this->data);
	}
	
	
	function add()
	{
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_wuser('ads/add',$this->data);
	}	
	
	
	
	function edit($id=0)
	{
		//安全处理
		$id = is_num($id,0);
		//获取当前编辑项信息
		$this->data["info"] = $this->TeamAd_Model->view($id,$this->logid);
		//防止空数据
		if(empty($this->data["info"])){show_404();}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_wuser('ads/edit',$this->data);
	}


	function save($id=0)
	{
		//安全处理
		$id = is_num($id,0);
		//保存数据(添加/编辑)
		$this->TeamAd_Model->save($id,$this->logid);
	}
	

	function del($id)
	{
		//安全处理
		$id = is_num($id,0);
		//删除数据
		$this->TeamAd_Model->del($id,$this->logid);
		//返回控制器
		$this->index();
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */