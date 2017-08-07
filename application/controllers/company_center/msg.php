<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msg extends COMPANY_Controller {

	function __construct()
	{
		parent::__construct();

		//分页模型
		$this->load->library('Paging');
		$this->load->model('Sendmsg_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '收到的消息','link' => 'receiver'),
					array('title' => '发出的消息','link' => 'send')
					/*,array('title' => '系统消息','link' => 'sys')*/
		            );
	}
	
	
	
	function index()
	{
		/*输出到视窗*/
		$this->receiver();
	}
	
	
	//收到的消息
	function receiver()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Sendmsg_Model->del_receiver($del_id,$this->logid);
		}
		
		//获取分页列表sql
		$listsql=$this->Sendmsg_Model->listsql_receiver($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
			 
		//更新数据
		$this->Sendmsg_Model->update_receiver($this->logid);
		
		$this->load->view_wuser('msg/receiver',$this->data);
	}
	
	
	//发送消息
	function send()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Sendmsg_Model->del_send($del_id,$this->logid);
		}
			
		//获取分页列表sql
		$listsql=$this->Sendmsg_Model->listsql_send($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		$this->load->view_wuser('msg/send',$this->data);
	}
	
	//收到的系统消息
	function sys()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Sendmsg_Model->del_receiver($del_id,$this->logid);
		}
		
		//获取分页列表sql
		$listsql = $this->Sendmsg_Model->listsql_sys($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		$this->load->view_wuser('msg/sys',$this->data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */