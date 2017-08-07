<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieval extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Retrieval_Model');
	}

	
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->Retrieval_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		/*输出到视窗*/
		$this->load->view_wuser('retrieval',$this->data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */