<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('TeamAd_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '管理广告','link' => 'index'),
					array('title' => '发布广告','link' => 'add')
		            );
	}
	
	
	
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->TeamAd_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('ads/index',$this->data);
	}
	
	
	function add()
	{
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view_wuser('ads/add',$this->data);
	}	
	
	
	
	function edit($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//获取当前编辑项信息
		$this->data["info"] = $this->TeamAd_Model->view($id,$this->logid);
		//防止空数据
		if(empty($this->data["info"])){show_404();}
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view_wuser('ads/edit',$this->data);
	}


	function save($id='')
	{
		//安全处理
		$id = get_num($id,'');
		//保存数据(添加/编辑)
		$this->TeamAd_Model->save($id,$this->logid);
	}
	

	function del($id)
	{
		//安全处理
		$id = get_num($id,'');
		//删除数据
		$this->TeamAd_Model->del($id,$this->logid);
		//返回控制器
		$this->index();
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */